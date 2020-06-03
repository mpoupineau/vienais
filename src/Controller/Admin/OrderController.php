<?php


namespace App\Controller\Admin;

use App\Entity\Order;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/** @Route("/admin/commande", name="admin_order") */
class OrderController extends AbstractController
{

    /**
     * @Route("", name="")
     */
    public function order()
    {
        return $this->render('admin/page/order.html.twig',
            [
                "orders" => $this->getDoctrine()->getRepository(Order::class)->findBy(
                    [],
                    [
                        "id" => 'DESC'
                    ]
                    )
            ]);
    }

    /**
     * @Route("/{orderId}", name="_details")
     */
    public function orderDetails($orderId)
    {

        $order = $this->getDoctrine()->getRepository(Order::class)->find($orderId);

        if ($order->isNew()) {
            $order->setNew(false);
            $this->getDoctrine()->getManager()->persist($order);
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('admin/page/order.html.twig',
            [
                "orders" => $this->getDoctrine()->getRepository(Order::class)->findBy(
                    [],
                    [
                        "id" => 'DESC'
                    ]
                ),
                'orderDetails' => $order
            ]);
    }
}