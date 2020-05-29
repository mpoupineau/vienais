<?php

namespace App\Controller;
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 22/02/19
 * Time: 15:54
 */

use App\Entity\Cuvee;
use App\Entity\News;
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
        return $this->render('client/page/home.html.twig',
            [
                "cuvee" => $this->getDoctrine()->getRepository(Cuvee::class)->findBy(
                    [
                        "visible" => true
                    ],
                    [
                        "priority" => 'DESC'
                    ],
                    1
                ),
                "news" => $this->getDoctrine()->getRepository(News::class)->findOneBy(
                    [
                        "homePage" => true
                    ]
                ),
                "photos" => $this->getDoctrine()->getRepository(Photo::class)->findBy(
                    [
                        "visible" => true
                    ],
                    [
                        "priority" => 'DESC'
                    ],
                    3
                )
            ]);
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
}