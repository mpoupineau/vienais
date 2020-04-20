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
use App\Entity\News;

/** @Route("/actualite", name="client_news") */
class NewsController extends AbstractController
{
    /**
     * @Route("", name="")
     */
    public function news()
    {
        return $this->render('client/page/news.html.twig',
            [
                'newsList' => $this->getDoctrine()->getRepository(News::class)->findBy(
                    [
                        "visible"=> true
                    ],
                    [
                        "createdAt" => 'DESC'
                    ]
                )
            ]);
    }

    /**
     * @Route("/{newsSlug}", name="_details")
     */
    public function getNewsDetails(Request $request, $newsSlug)
    {
        $news = $this->getDoctrine()->getRepository(News::class)->findBy(
            [
                "slug" => $newsSlug
            ]);

        return $this->render('client/page/news/news_details.html.twig',
            [
                'news' => $news[0],
                'newsList' => $this->getDoctrine()->getRepository(News::class)->findBy(
                    [
                        "visible"=> true
                    ],
                    [
                        "createdAt" => 'DESC'
                    ]
                )
            ]);
    }
}