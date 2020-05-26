<?php

namespace App\Controller\Client;
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 22/02/19
 * Time: 15:54
 */

use App\Entity\Vintage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cuvee;

/** @Route("/nos-vins", name="client_wine") */
class WineController extends AbstractController
{
    /**
     * @Route("", name="")
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
                "vintages" => $this->getDoctrine()->getRepository(Vintage::class)->findBy(
                    [
                        "visible" => true
                    ],
                    [
                        "priority" => "DESC"
                    ]
                )
            ]);
    }
    /**
     * @Route("/partial/cuvee/{cuveeId}", options = { "expose" = true }, name="_partial_cuvee_details")
     */
    public function getCuveeDetails(Request $request, $cuveeId)
    {
        $cuvee = $this->getDoctrine()->getRepository(Cuvee::class)->find($cuveeId);
        return $this->render('client/page/wine/modalCuveeDetails.html.twig',
            [
                'cuvee' => $cuvee
            ]);
    }

    /**
     * @Route("/partial/vintage/{vintageId}", options = { "expose" = true }, name="_partial_vintage_details")
     */
    public function getVintageDetails(Request $request, $vintageId)
    {
        $vintage = $this->getDoctrine()->getRepository(Vintage::class)->find($vintageId);
        return $this->render('client/page/wine/modalVintageDetails.html.twig',
            [
                'vintage' => $vintage
            ]);
    }
}