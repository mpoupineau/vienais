<?php


namespace App\Manager;


use App\Entity\Order;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Address;

class MailerManager
{


    public static function onlinePaymentOrder(Order $order)
    {
        return (new TemplatedEmail())
            ->from(new Address('contact@domaine-des-vienais.com', 'Domaine des Vienais'))
            ->to(new Address($order->getDeliveryAddress()->getEmail(), $order->getDeliveryAddress()->getFirstname() . ' ' . $order->getDeliveryAddress()->getLastname()))
            ->subject('Confirmation de commande')
            ->htmlTemplate('client/mail/orderOnlinePayment.html.twig')
            ->context([
                'order' => $order
            ]);
    }

    public static function onlineCheckOrder(Order $order)
    {
        return (new TemplatedEmail())
            ->from(new Address('contact@domaine-des-vienais.com', 'Domaine des Vienais'))
            ->to(new Address($order->getDeliveryAddress()->getEmail(), $order->getDeliveryAddress()->getFirstname() . ' ' . $order->getDeliveryAddress()->getLastname()))
            ->subject('Confirmation de commande')
            ->htmlTemplate('client/mail/orderCheckPayment.html.twig')
            ->context([
                'order' => $order
            ]);
    }

    public static function onlinePaymentOrderMock(Order $order)
    {
        return (new TemplatedEmail())
            ->from(new Address('contact@domaine-des-vienais.com', 'Domaine des Vienais'))
            ->to(new Address('poupimat@gmail.com', 'Matthieu Poupineau'))
            ->subject('Confirmation de commande')
            ->htmlTemplate('client/mail/orderOnlinePayment.html.twig')
            ->context([
                'order' => $order
            ]);
    }

    public static function checkPaymentOrder(Order $order)
    {
        return (new TemplatedEmail())
            ->from(new Address('contact@domaine-des-vienais.com', 'Domaine des Vienais'))
            ->to(new Address($order->getDeliveryAddress()->getEmail(), $order->getDeliveryAddress()->getFirstname() . ' ' . $order->getDeliveryAddress()->getLastname()))
            ->subject('Confirmation de commande')
            ->htmlTemplate('mail/checkOnlinePayment.html.twig')
            ->context([
                'order' => $order
            ]);
    }
}