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

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $order = $orderManager->add($bottlesOrdered, $form->getData());
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
                "bottlesOrdered" => $bottlesOrdered
            ]);
    }

    /**
     * @Route("/paiement/{orderId}", name="_payment")
     */
    public  function payment($orderId)
    {
        return $this->render('client/page/order/payment.html.twig',
            [
                "order" => $this->getDoctrine()->getRepository(Order::class)->find($orderId)
            ]);
    }

    /**
     * @Route("/recapitulatif/{orderId}/{type}", options = { "expose" = true }, name="_summary")
     */
    public function successPayment($orderId, $type)
    {
        return $this->render('client/page/order/summary.html.twig',
            [
                "order" => $this->getDoctrine()->getRepository(Order::class)->find($orderId)
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
}