<?php
namespace App\Controller\Admin;

/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 23/02/19
 * Time: 15:31
 */

use App\Entity\Bottle;
use App\Form\Admin\CuveeType;
use App\Entity\Cuvee;
use App\Product\CuveeManager;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/** @Route("/admin/product/", name="admin_product_") */
class ProductController extends AbstractController
{
    /**
     * @Route("cuvee", name="cuvee")
     */
    public function cuvee(Request $request, CuveeManager $cuveeManager)
    {
        $form = $this->createForm(CuveeType::class, new Cuvee());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cuveeManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Cuvee Ajoutée");
        }

        return $this->render('admin/page/product/cuvee.html.twig',
            [
                'cuvees' => $this->getDoctrine()->getRepository(Cuvee::class)->findAll(),
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("cuvee/{cuveeId}", name="cuvee_update")
     */
    public function cuvee_update(Request $request, CuveeManager $cuveeManager, $cuveeId)
    {
        $cuvee = $this->getDoctrine()->getRepository(Cuvee::class)->find($cuveeId);

        if (!$cuvee) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver la cuvée n°' . $cuveeId);
            return $this->redirectToRoute('admin_product_cuvee');
        }

        $form = $this->createForm(CuveeType::class, $cuvee);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cuveeManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Cuvee modifié");
            return $this->redirectToRoute('admin_product_cuvee');
        }

        return $this->render('admin/page/product/cuvee_update.html.twig',
            [
                'cuvees' => $this->getDoctrine()->getRepository(Cuvee::class)->findAll(),
                'form' => $form->createView()
            ]);
    }

    /**
     * @Route("cuvee/{cuveeId}/delete", name="cuvee_delete")
     */
    public function cuvee_delete(CuveeManager $cuveeManager, $cuveeId)
    {
        $cuvee = $this->getDoctrine()->getRepository(Cuvee::class)->find($cuveeId);

        if (!$cuvee) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver la cuvée n°' . $cuveeId);
            return $this->redirectToRoute('admin_product_cuvee');
        }

        $cuveeManager->delete($cuvee);
        $session = new Session();
        $session->getFlashBag()->add('success', "Cuvée \"" . $cuvee->getName() . "\" supprimé");
        return $this->redirectToRoute('admin_product_cuvee');
    }

    /**
     * @Route("bottle", name="bottle")
     */
    public function bottle(Request $request, CuveeManager $cuveeManager)
    {
        /*$form = $this->createForm(CuveeType::class, new Cuvee());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $cuveeManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Cuvee Ajoutée");
        }*/

        return $this->render('admin/page/product/bottle.html.twig',
            [
                'bottles' => $this->getDoctrine()->getRepository(Bottle::class)->findAll()
            ]);
    }
}