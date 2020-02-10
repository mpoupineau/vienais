<?php
/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 20/01/20
 * Time: 18:32
 */

namespace App\Controller\Admin;

use App\Entity\Photo;
use App\Entity\PhotoTag;
use App\Form\Admin\Photo\PhotoType;
use App\Form\Admin\Photo\PhotoTagType;
use App\Manager\Photo\PhotoManager;
use App\Manager\Photo\PhotoTagManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/** @Route("/admin/photo/", name="admin_photo_") */
class PhotoController extends AbstractController
{
    /**
     * @Route("photo", name="photo")
     */
    public function photo(Request $request, PhotoManager $photoManager)
    {
        $form = $this->createForm(PhotoType::class, new Photo());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Photo Ajoutée");
        }

        return $this->render('admin/page/photo/photo.html.twig',
            [
                'photos' => $this->getDoctrine()->getRepository(Photo::class)->findAll(),
                'form' => $form->createView(),
                'action' => 'add'
            ]);
    }

    /**
     * @Route("photo/{photoId}", name="photo_update")
     */
    public function photo_update(Request $request, PhotoManager $photoManager, $photoId)
    {
        $photo = $this->getDoctrine()->getRepository(Photo::class)->find($photoId);

        if (!$photo) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver la photo n°' . $photoId);
            return $this->redirectToRoute('admin_photo_photo');
        }

        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Photo modifiée");
            return $this->redirectToRoute('admin_photo_photo');
        }

        return $this->render('admin/page/photo/photo_update.html.twig',
            [
                'photos' => $this->getDoctrine()->getRepository(Photo::class)->findAll(),
                'form' => $form->createView(),
                'action' => 'update'
            ]);
    }

    /**
     * @Route("photo/{photoId}/delete", name="photo_delete")
     */
    public function photo_delete(PhotoManager $photoManager, $photoId)
    {
        $photo = $this->getDoctrine()->getRepository(Photo::class)->find($photoId);

        if (!$photo) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver l\'étiquette n°' . $photoId);
            return $this->redirectToRoute('admin_photo_tag');
        }

        $photoManager->delete($photo);
        $session = new Session();
        $session->getFlashBag()->add('success', "Photo supprimée");
        return $this->redirectToRoute('admin_photo_photo');
    }

    /**
     * @Route("tag", name="tag")
     */
    public function tag(Request $request, PhotoTagManager $photoTagManager)
    {
        $form = $this->createForm(PhotoTagType::class, new PhotoTag());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $photoTagManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Étiquette Ajoutée");
        }

        return $this->render('admin/page/photo/tag.html.twig',
            [
                'photoTags' => $this->getDoctrine()->getRepository(PhotoTag::class)->findAll(),
                'form' => $form->createView(),
                'action' => 'add'
            ]);
    }

    /**
     * @Route("tag/{tagId}", name="tag_update")
     */
    public function tag_update(Request $request, PhotoTagManager $tagManager, $tagId)
    {
        $tag = $this->getDoctrine()->getRepository(PhotoTag::class)->find($tagId);

        if (!$tag) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver la cuvée n°' . $tagId);
            return $this->redirectToRoute('admin_photo_tag');
        }

        $form = $this->createForm(PhotoTagType::class, $tag);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tagManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Capacité modifiée");
            return $this->redirectToRoute('admin_photo_tag');
        }

        return $this->render('admin/page/photo/tag.html.twig',
            [
                'photoTags' => $this->getDoctrine()->getRepository(PhotoTag::class)->findAll(),
                'form' => $form->createView(),
                'action' => 'update'
            ]);
    }

    /**
     * @Route("tag/{tagId}/delete", name="tag_delete")
     */
    public function tag_delete(PhotoTagManager $tagManager, $tagId)
    {
        $tag = $this->getDoctrine()->getRepository(PhotoTag::class)->find($tagId);

        if (!$tag) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver l\'étiquette n°' . $tagId);
            return $this->redirectToRoute('admin_photo_tag');
        }

        $tagManager->delete($tag);
        $session = new Session();
        $session->getFlashBag()->add('success', "Etiquette \"" . $tag->getName() . "\" supprimée");
        return $this->redirectToRoute('admin_photo_tag');
    }
}