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
use App\Entity\Order;
use App\Entity\Vintage;
use App\Form\Client\Order\DeliveryAddressType;
use App\Manager\OrderManager;
use App\Manager\SessionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/commande", name="client_order") */
class OrderController extends AbstractController
{
    /**
     * @Route("", name="")
     */
    public function order(SessionManager $sessionManager)
    {
        return $this->render('client/page/order.html.twig',
            [
                "vintages" => $this->getDoctrine()->getRepository(Vintage::class)->findBy(
                    [
                        "visible" => true
                    ],
                    [
                        "priority" => "DESC"
                    ]
                ),
                "bottlesOrdered" => $sessionManager->getBottles()
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
        $subPrice = $orderManager->calculateSubPrice($bottlesOrdered);
        $deliveryFees = $orderManager->calculateDeliveryFees($bottlesOrdered);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $order = $orderManager->add($bottlesOrdered, $form->getData());
                $sessionManager->removeBottles();
                return $this->redirectToRoute('client_order_payment', ["orderId" => $order->getId()]);
            } else {
                dump('error');
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
                "totalPrice" => $orderManager->calculateTotalPrice($deliveryFees, $subPrice)
            ]);
    }

    /**
     * @Route("/paiement/{orderReference}", name="_payment")
     */
    public function payment($orderReference)
    {
        $order = $this->getDoctrine()->getRepository(Order::class)->findOneBy(
            [
                "reference" => $orderReference
            ]
        );

        return $this->render('client/page/order/payment.html.twig',
            [
                "order" => $order
            ]);
    }

    /**
     * @Route("/paiement/{orderReference}/{paymentType}", requirements={"paymentType": "card|check"}, options = { "expose" = true }, name="_payment_choice")
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

        if ("check" === $paymentType) {
            return $this->redirectToRoute('client_order_summary', ['orderReference' => $order->getReference()]);
        } else {
            return $this->redirectToRoute('client_order_payment_redirect', ['orderReference' => $order->getReference()]);
        }
    }

    /**
     * @Route("/paiement/{orderReference}/redirection", name="_payment_redirect")
     */
    public function startCardPayment($orderReference)
    {
        return $this->render('client/page/order/redirect.html.twig',
            [
                "order" => $this->getDoctrine()->getRepository(Order::class)->findOneBy(
                    [
                        "reference" => $orderReference
                    ]
                )
            ]);
    }

    /**
     * @Route("/paiement/{orderReference}/success", name="_payment_success")
     */
    public function successPayment($orderReference, OrderManager $orderManager)
    {
        /** @var Order $order */
        $order = $this->getDoctrine()->getRepository(Order::class)->findOneBy(
            [
                "reference" => $orderReference
            ]
        );

        try {
            $orderManager->setPaymentResult($order, "success");
            return $this->redirectToRoute('client_order_summary', ['orderReference' => $order->getReference()]);
        } catch (\Exception $exception) {
            return $this->redirectToRoute('client_order_summary', ['orderReference' => $order->getReference()]);
        }
    }

    /**
     * @Route("/paiement/{orderReference}/cancelled", name="_payment_cancelled")
     */
    public function cancelledPayment($orderReference, OrderManager $orderManager)
    {
        /** @var Order $order */
        $order = $this->getDoctrine()->getRepository(Order::class)->findOneBy(
            [
                "reference" => $orderReference
            ]
        );

        try {
            $orderManager->setPaymentResult($order, "cancelled");
            return $this->redirectToRoute('client_order_summary', ['orderReference' => $order->getReference()]);
        } catch (\Exception $exception) {
            return $this->redirectToRoute('client_order_summary', ['orderReference' => $order->getReference()]);
        }
    }

    /**
     * @Route("/recapitulatif/{orderReference}", options = { "expose" = true }, name="_summary")
     */
    public function endPayment($orderReference)
    {
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
    public function updateBottle(Request $request, OrderManager $orderManager)
    {
        return $this->json(['deliveryFees' => $orderManager->calculateDeliveryFees($request->get('bottles'))]);
    }
}