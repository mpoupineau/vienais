<?php


namespace App\Controller\Admin;

use App\Entity\News;
use App\Form\Admin\News\NewsType;
use App\Manager\News\NewsManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/admin/news", name="admin_news") */
class NewsController extends AbstractController
{
    /**
     * @Route("", name="")
     */
    public function news(Request $request, NewsManager $newsManager)
    {
        $form = $this->createForm(NewsType::class, new News());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newsManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Actualité Ajoutée");
        }

        return $this->render('admin/page/news/news.html.twig',
            [
                'newsList' => $this->getDoctrine()->getRepository(News::class)->findBy(
                    [],
                    [
                        'createdAt' => "DESC"
                    ]
                ),
                'form' => $form->createView(),
                'action' => 'add'
            ]);
    }

    /**
     * @Route("/{newsId}", name="_update")
     */
    public function news_update(Request $request, NewsManager $newsManager, $newsId)
    {
        $news = $this->getDoctrine()->getRepository(News::class)->find($newsId);

        if (!$news) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver la news n°' . $newsId);
            return $this->redirectToRoute('admin_photo_photo');
        }

        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $newsManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Actualité modifiée");
            return $this->redirectToRoute('admin_news');
        }

        return $this->render('admin/page/news/news_update.html.twig',
            [
                'newsList' => $this->getDoctrine()->getRepository(News::class)->findBy(
                    [],
                    [
                        'createdAt' => "DESC"
                    ]
                ),
                'form' => $form->createView(),
                'action' => 'update'
            ]);
    }
}