<?php

namespace App\Controller;
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 22/02/19
 * Time: 15:54
 */

use App\Entity\Cuvee;
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
     * @Route("/nos-vins", name="client_wine")
     */
    public function wine()
    {
        return $this->render('client/page/wine.html.twig',
            [
                'cuvees' => $this->getDoctrine()->getRepository(Cuvee::class)->findAll()
            ]);;
    }

    /**
     * @Route("/contact", name="client_contact")
     */
    public function contact()
    {
        return $this->render('client/page/contact.html.twig');
    }
}