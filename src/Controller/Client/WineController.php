<?php

namespace App\Controller\Client;
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 22/02/19
 * Time: 15:54
 */

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cuvee;

class WineController extends AbstractController
{
    /**
     * @Route("/partial/cuvee/{cuveeId}", options = { "expose" = true }, name="product_partial_cuvee_details")
     */
    public function getCuveeDetails(Request $request, $cuveeId)
    {
        $cuvee = $this->getDoctrine()->getRepository(Cuvee::class)->find($cuveeId);
        return $this->render('client/page/wine/modalCuveeDetails.html.twig',
            [
                'cuvee' => $cuvee
            ]);
    }
}