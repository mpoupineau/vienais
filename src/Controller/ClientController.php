<?php

namespace App\Controller;
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 22/02/19
 * Time: 15:54
 */

use App\Entity\Bottle;
use App\Entity\Cuvee;
use App\Entity\Photo;
use App\Entity\PhotoTag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

    /**
     * @Route("/", name="client_home")
     */
    public function home()
    {
        return $this->render('client/page/home.html.twig');
    }

    /**
     * @Route("/le-domaine", name="client_presentation")
     */
    public function presentation()
    {
        return $this->render('client/page/presentation.html.twig');
    }

    /**
     * @Route("/galerie", name="client_gallery")
     */
    public function gallery()
    {
        return $this->render('client/page/gallery.html.twig',
            [
                'photos' => $this->getDoctrine()->getRepository(Photo::class)->findBy(
                    [
                        "visible"=> true
                    ],
                    [
                        "priority" => 'DESC'
                    ]
                ),
                "photoTags" => $this->getDoctrine()->getRepository(PhotoTag::class)->findAll()
            ]);
    }

    /**
     * @Route("/nos-vins", name="client_wine")
     */
    public function wine()
    {
        return $this->render('client/page/wine.html.twig',
            [
                'cuvees' => $this->getDoctrine()->getRepository(Cuvee::class)->findBy(
                    [
                        "visible"=> true
                    ]
                ),
                "bottles" => $this->getDoctrine()->getRepository(Bottle::class)->findBy(
                    [
                        "visible" => true
                    ],
                    [
                        "cuvee" => "ASC"
                    ]
                )
            ]);
    }

    /**
     * @Route("/commande", name="client_order")
     */
    public function order()
    {
        return $this->render('client/page/order.html.twig');
    }
}