<?php

namespace App\Controller\Admin;

use App\Entity\DeliveryFees;
use App\Entity\DeliveryFeesGroup;
use App\Form\Admin\Photo\DeliveryFeesGroupType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/admin/frais-de-port", name="admin_delivery_fees") */
class DeliveryFeesController extends AbstractController
{

    /**
     * @Route("", name="")
     */
    public function deliveryFees(Request $request)
    {

        $deliveryFeesGroup = new DeliveryFeesGroup();
        $deliveryFeesGroup->setDeliveryFees($this->getDoctrine()->getRepository(DeliveryFees::class)->findAll());

        $form = $this->createForm(DeliveryFeesGroupType::class, $deliveryFeesGroup);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $session = new Session();
            if ($form->isValid()) {
                foreach ($form->getData()->getDeliveryFees() as $deliveryFee) {
                    dump($deliveryFee);
                    $this->getDoctrine()->getManager()->persist($deliveryFee);
                }
                $this->getDoctrine()->getManager()->flush();
                $session->getFlashBag()->add('success', "Les frais de port ont été modifié");
            } else {
                $session->getFlashBag()->add('warning', "La modification des frais de port a échoué");
            }
        }

        return $this->render('admin/page/deliveryFees.html.twig',
            [
                'form' => $form->createView(),
            ]);
    }

}