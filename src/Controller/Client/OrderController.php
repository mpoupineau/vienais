<?php

namespace App\Controller\Client;
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 22/02/19
 * Time: 15:54
 */

use App\Entity\Bottle;
use App\Entity\DeliveryAddress;
use App\Entity\DeliveryFees;
use App\Entity\Order;
use App\Entity\PromoCode;
use App\Entity\Vintage;
use App\Form\Client\Order\DeliveryAddressType;
use App\Manager\MailerManager;
use App\Manager\OrderManager;
use App\Manager\PaypalManager;
use App\Manager\SessionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/commande", name="client_order") */
class OrderController extends AbstractController
{
    /*
     * @Route("/mail/{orderReference}", name="_mail")
     * /
    public function mail($orderReference, MailerInterface $mailer)
    {
        /** @var Order $order * /
        $order = $this->getDoctrine()->getRepository(Order::class)->findOneBy(
            [
                "reference" => $orderReference
            ]
        );

        try {
            $mailer->send(MailerManager::onlinePaymentOrderMock($order));
        } catch (TransportExceptionInterface $exception) {

        } catch (\Exception $exception) {

        }

        return $this->render('client/mail/orderOnlinePayment.html.twig',
            [
                "order" => $order
            ]);
    }*/

    /*
     * @Route("/pay_mock/{orderReference}", name="_pay_mock")
     * /
    public function paiementMcok($orderReference, MailerInterface $mailer)
    {
        /** @var Order $order * /
        $order = $this->getDoctrine()->getRepository(Order::class)->findOneBy(
            [
                "reference" => $orderReference
            ]
        );

        try {
            $orderPage = PaypalManager::getOrderPage($order,
                "http://".$_SERVER['HTTP_HOST'].$this->generateUrl('client_order_payment_result', [
                    'orderReference' => $order->getReference(),
                    'paymentResult' => 'success'
                ]),
                "http://".$_SERVER['HTTP_HOST'].$this->generateUrl('client_order_payment_result', [
                    'orderReference' => $order->getReference(),
                    'paymentResult' => 'cancelled'
                ])
            );
            dump($orderPage);
        } catch (\Exception $ex) {
            return $this->render('client/page/order/payment.html.twig',
                [
                    "order" => $order
                ]);
        }

        return $this->render('client/page/order/payment.html.twig',
            [
                "order" => $order
            ]);
    }*/

    /**
     * @Route("", name="")
     */
    public function order(SessionManager $sessionManager)
    {
        return $this->render('client/page/order.html.twig',
            [
                "vintages" => $this->getDoctrine()->getRepository(Vintage::class)->findBy(
                    [],
                    [
                        "priority" => "DESC"
                    ]
                ),
                "bottlesOrdered" => $sessionManager->getBottles(),
                "promoCode" => $this->getDoctrine()->getRepository(PromoCode::class)->find($sessionManager->getPromoCode()),
                "deliveryFees" => $this->getDoctrine()->getRepository(DeliveryFees::class)->findBy(
                    [],
                    [
                        "quantity" => "ASC"
                    ]
                )
            ]);
    }

    /**
     * @Route("/livraison", name="_delivery")
     */
    public function delivery(Request $request, SessionManager $sessionManager, OrderManager $orderManager)
    {
        $form = $this->createForm(DeliveryAddressType::class, new DeliveryAddress());
        $form->handleRequest($request);

        $bottlesOrdered = $sessionManager->getBottles();
        $promoCodeSession = $sessionManager->getPromoCode();

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $order = $orderManager->add($bottlesOrdered, $form->getData(), $promoCodeSession);
                $sessionManager->removeBottles();
                $sessionManager->removePromoCode();
                return $this->redirectToRoute('client_order_payment', ["orderReference" => $order->getReference()]);
            }
        }

        $subPrice = $orderManager->calculateSubPrice($bottlesOrdered);
        $deliveryFees = $orderManager->calculateDeliveryFees($bottlesOrdered);
        $totalDiscount = 0;

        if ("" !== $promoCodeSession) {
            $promoCode = $this->getDoctrine()->getRepository(PromoCode::class)->find($promoCodeSession);
            if ($promoCode && $promoCode->isValid()) {
                $totalDiscount = $orderManager->calculateDiscount($promoCodeSession, $deliveryFees);
            }
        }

        return $this->render('client/page/order/delivery.html.twig',
            [
                'deliveryForm' => $form->createView(),
                "bottles" => $this->getDoctrine()->getRepository(Bottle::class)->findBy(
                    [
                        "available" => true
                    ]
                ),
                "bottlesOrdered" => $bottlesOrdered,
                "subPrice" => $subPrice,
                "deliveryFees" => $deliveryFees,
                "discount" => $totalDiscount,
                "totalPrice" => $orderManager->calculateTotalPrice($deliveryFees, $subPrice, $totalDiscount)
            ]);
    }

    /**
     * @Route("/paiement/{orderReference}", name="_payment")
     */
    public function payment($orderReference)
    {
        /** @var Order $order */
        $order = $this->getDoctrine()->getRepository(Order::class)->findOneBy(
            [
                "reference" => $orderReference
            ]
        );

        if (Order::STATE_INIT !== $order->getState()) {
            return $this->redirectToRoute('client_order_summary', ['orderReference' => $order->getReference()]);
        }

        return $this->render('client/page/order/payment.html.twig',
            [
                "order" => $order
            ]);
    }

    /**
     * @Route("/paiement/{orderReference}/{paymentType}", requirements={"paymentType": "carte|cheque"}, options = { "expose" = true }, name="_payment_choice")
     */
    public function paymentChoice($orderReference, $paymentType, OrderManager $orderManager)
    {
        /** @var Order $order */
        $order = $this->getDoctrine()->getRepository(Order::class)->findOneBy(
            [
                "reference" => $orderReference
            ]
        );

        $orderManager->setPaymentType($order, $paymentType);

        if (Order::PAYMENT_TYPE_CHECK === $paymentType) {
            return $this->redirectToRoute('client_order_summary', ['orderReference' => $order->getReference()]);
        } else {
            return $this->redirectToRoute('client_order_payment_redirect', ['orderReference' => $order->getReference()]);
        }
    }

    /**
     * @Route("/paiement/{orderReference}/redirection", name="_payment_redirect")
     */
    public function startCardPayment($orderReference, OrderManager $orderManager)
    {
        /** @var Order $order */
        $order = $this->getDoctrine()->getRepository(Order::class)->findOneBy(
            [
                "reference" => $orderReference
            ]
        );

        try {
            $result = PaypalManager::getOrderPage($order,
                getenv("SECURE_SCHEME") . "://".$_SERVER['HTTP_HOST'].$this->generateUrl('client_order_payment_result', [
                    'orderReference' => $order->getReference(),
                    'paymentResult' => 'success'
                ]),
                getenv("SECURE_SCHEME") . "://".$_SERVER['HTTP_HOST'].$this->generateUrl('client_order_payment_result', [
                    'orderReference' => $order->getReference(),
                    'paymentResult' => 'cancelled'
                ])
            );
        } catch (\Exception $ex) {
            return $this->render('client/page/order/payment.html.twig',
                [
                    "order" => $order
                ]);
        }

        $orderManager->setTppReference($order, $result['paypalOrderId']);

        return $this->render('client/page/order/redirect.html.twig',
            [
                "order" => $this->getDoctrine()->getRepository(Order::class)->findOneBy(
                    [
                        "reference" => $orderReference
                    ]
                ),
                "redirectUrl" => $result['orderPage']
            ]);
    }

    /**
     * @Route("/paiement/{orderReference}/{paymentResult}", requirements={"paymentResult": "success|cancelled"}, name="_payment_result")
     */
    public function resultPayment($orderReference, $paymentResult, OrderManager $orderManager)
    {
        /** @var Order $order */
        $order = $this->getDoctrine()->getRepository(Order::class)->findOneBy(
            [
                "reference" => $orderReference
            ]
        );

        $orderManager->setPaymentResult($order, $paymentResult);

        if ("success" === $paymentResult) {
            PaypalManager::captureOrder($order->getTppReference());
        }

        return $this->redirectToRoute('client_order_summary', ['orderReference' => $order->getReference()]);
    }

    /**
     * @Route("/recapitulatif/{orderReference}", options = { "expose" = true }, name="_summary")
     */
    public function endPayment($orderReference, MailerInterface $mailer, OrderManager $orderManager)
    {

        /** @var Order $order */
        $order = $this->getDoctrine()->getRepository(Order::class)->findOneBy(
            [
                "reference" => $orderReference
            ]
        );

        if (in_array($order->getState(), [Order::STATE_PAID, Order::STATE_WAITING_FOR_CHECK])) {
            if (!$order->isMailSent()) {
                if (Order::PAYMENT_TYPE_CHECK === $order->getPaymentType()) {
                    $mail = MailerManager::onlineCheckOrder($order);
                } else {
                    $mail = MailerManager::onlinePaymentOrder($order);
                }

                try {
                    $mailer->send($mail);
                    $orderManager->mailSent($order);
                } catch (\Exception $exception) {
                }
            }
        }

        return $this->render('client/page/order/summary.html.twig',
            [
                "order" => $this->getDoctrine()->getRepository(Order::class)->findOneBy(
                    [
                        "reference" => $orderReference
                    ]
                )
            ]);
    }

    /**
     * @Route("/partial/bottles-number", name="_partial_bottles_number")
     */
    public function getBottlesNumber(SessionManager $sessionManager)
    {
        $bottlesOrdered = $sessionManager->getBottles();

        $bottlesNumber = 0;

        foreach ($bottlesOrdered as $bottleOrdered) {
            if ("" !== $bottleOrdered) {
                $bottlesNumber += $bottleOrdered;
            }
        }

        return $this->render('client/inc/bottlesNumber.html.twig',
            [
                "bottlesNumber" => $bottlesNumber
            ]);
    }

    /**
     * @Route("/partial/delivery-fees/update", options = { "expose" = true }, name="_partial_deliveryfees")
     */
    public function updateBottle(Request $request, OrderManager $orderManager, SessionManager $sessionManager)
    {
        $deliveryFees = $orderManager->calculateDeliveryFees($request->get('bottles'));
        return $this->json([
            'deliveryFees' => $deliveryFees,
            'discount' => $orderManager->calculateDiscount($sessionManager->getPromoCode(), $deliveryFees)
        ]);
    }

    /**
     * @Route("/partial/promo_code/verify", options = { "expose" = true }, name="_partial_promocode")
     */
    public function verifyPromoCode(Request $request, SessionManager $sessionManager)
    {
        /** @var PromoCode $promoCode */
        $promoCode = $this->getDoctrine()->getRepository(PromoCode::class)->findOneBy(
            [
                'code' => $request->get('code')
            ]
        );

        if (!$promoCode) {
            return $this->json(
                [
                    'status' => 'error',
                    'message' => 'code not found'
                ]
            );
        }

        if (!$promoCode->isValid()) {
            return $this->json(
                [
                    'status' => 'error',
                    'message' => 'Ce code est expiré'
                ]
            );
        }


        $sessionManager->updatePromoCode($promoCode->getId());

        return $this->json(
            [
                'status' => 'success',
                'message' => 'code found',
                'promoCode' => $promoCode
            ]
        );
    }
}