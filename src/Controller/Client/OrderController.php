<?php

namespace App\Controller\Client;
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 22/02/19
 * Time: 15:54
 */


use App\Entity\Vintage;
use App\Manager\SessionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
                        "priority" => "ASC"
                    ]
                ),
                "bottlesOrdered" => $sessionManager->getBottles()
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