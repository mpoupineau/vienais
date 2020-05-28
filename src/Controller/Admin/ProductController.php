<?php
namespace App\Controller\Admin;

/**
 * Created by PhpStorm.
 * User: mpoupineau
 * Date: 23/02/19
 * Time: 15:31
 */

use App\Entity\Bottle;
use App\Entity\Capacity;
use App\Entity\Vintage;
use App\Entity\WineType;
use App\Form\Admin\Product\BottleType;
use App\Form\Admin\Product\CuveeType;
use App\Form\Admin\Product\CapacityType;
use App\Form\Admin\Product\VintageType;
use App\Form\Admin\Product\WineTypeType;
use App\Entity\Cuvee;
use App\Manager\Product\BottleManager;
use App\Manager\Product\CapacityManager;
use App\Manager\Product\CuveeManager;
use App\Manager\Product\VintageManager;
use App\Manager\Product\WineTypeManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;

/** @Route("/admin/product/", name="admin_product_") */
class ProductController extends AbstractController
{
    /**
     * @Route("bouteille", name="bottle")
     */
    public function bottle(Request $request, BottleManager $bottleManager)
    {
        $form = $this->createForm(BottleType::class, new Bottle());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bottleManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Bouteille Ajoutée");
        }

        return $this->render('admin/page/product/bottle.html.twig',
            [
                'bottles' => $this->getDoctrine()->getRepository(Bottle::class)->findBy(
                    [],
                    []
                ),
                'form' => $form->createView(),
                'action' => 'add'
            ]);
    }

    /**
     * @Route("bouteille/{bottleId}", name="bottle_update")
     */
    public function bottle_update(Request $request, BottleManager $bottleManager, $bottleId)
    {
        $bottle = $this->getDoctrine()->getRepository(Bottle::class)->find($bottleId);

        if (!$bottle) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver la cuvée n°' . $bottleId);
            return $this->redirectToRoute('admin_product_bottle');
        }

        $form = $this->createForm(BottleType::class, $bottle);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $bottleManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Bouteille modifiée");
            return $this->redirectToRoute('admin_product_bottle');
        }

        return $this->render('admin/page/product/bottle.html.twig',
            [
                'bottles' => $this->getDoctrine()->getRepository(Bottle::class)->findBy(
                    [],
                    []
                ),
                'form' => $form->createView(),
                'action' => 'update'
            ]);
    }

    /**
     * @Route("bouteille/{bottleId}/delete", name="bottle_delete")
     */
    public function bottle_delete(BottleManager $bottleManager, $bottleId)
    {
        $bottle = $this->getDoctrine()->getRepository(Bottle::class)->find($bottleId);

        if (!$bottle) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver la bouteille n°' . $bottleId);
            return $this->redirectToRoute('admin_product_bottle');
        }

        $bottleManager->delete($bottle);
        $session = new Session();
        $session->getFlashBag()->add('success', "Bouteille \"" . $bottle->getName() . "\" supprimée");
        return $this->redirectToRoute('admin_product_bottle');
    }

    /**
     * @Route("cuvee", name="cuvee")
     */
    public function cuvee(Request $request, CuveeManager $cuveeManager)
    {
        $form = $this->createForm(CuveeType::class, new Cuvee());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $session = new Session();

            if ($form->isValid()) {
                $cuveeManager->add($form->getData());
                $session->getFlashBag()->add('success', "Cuvee Ajoutée");
            } else {
                $session->getFlashBag()->add('warning', "L'ajout de la cuvée a échoué");
            }
        }

        return $this->render('admin/page/product/cuvee.html.twig',
            [
                'cuvees' => $this->getDoctrine()->getRepository(Cuvee::class)->findBy(
                    [],
                    [
                        'priority' => 'DESC'
                    ]
                ),
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

        if ($form->isSubmitted()) {
            $session = new Session();

            if ($form->isValid()) {
                $cuveeManager->add($form->getData());
                $session->getFlashBag()->add('success', "Cuvee modifié");
                return $this->redirectToRoute('admin_product_cuvee');
            } else {
                $session->getFlashBag()->add('warning', "La modification de la cuvee a échoué");
            }
    }

        return $this->render('admin/page/product/cuvee_update.html.twig',
            [
                'cuvees' => $this->getDoctrine()->getRepository(Cuvee::class)->findBy(
                    [],
                    [
                        'priority' => 'DESC'
                    ]
                ),
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
     * @Route("type-de-vin", name="wineType")
     */
    public function wineType(Request $request, WineTypeManager $wineTypeManager)
    {
        $form = $this->createForm(WineTypeType::class, new WineType());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wineTypeManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Capacité Ajoutée");
        }

        return $this->render('admin/page/product/wineType.html.twig',
            [
                'capacities' => $this->getDoctrine()->getRepository(WineType::class)->findAll(),
                'form' => $form->createView(),
                'action' => 'add'
            ]);
    }

    /**
     * @Route("wineType/{wineTypeId}", name="wineType_update")
     */
    public function wineType_update(Request $request, WineTypeManager $wineTypeManager, $wineTypeId)
    {
        $wineType = $this->getDoctrine()->getRepository(WineType::class)->find($wineTypeId);

        if (!$wineType) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver la cuvée n°' . $wineTypeId);
            return $this->redirectToRoute('admin_product_wineType');
        }

        $form = $this->createForm(WineTypeType::class, $wineType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $wineTypeManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Capacité modifiée");
            return $this->redirectToRoute('admin_product_wineType');
        }

        return $this->render('admin/page/product/wineType.html.twig',
            [
                'capacities' => $this->getDoctrine()->getRepository(WineType::class)->findAll(),
                'form' => $form->createView(),
                'action' => 'update'
            ]);
    }

    /**
     * @Route("wineType/{wineTypeId}/delete", name="wineType_delete")
     */
    public function wineType_delete(WineTypeManager $wineTypeManager, $wineTypeId)
    {
        $wineType = $this->getDoctrine()->getRepository(WineType::class)->find($wineTypeId);

        if (!$wineType) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver la capacité n°' . $wineTypeId);
            return $this->redirectToRoute('admin_product_wineType');
        }

        $wineTypeManager->delete($wineType);
        $session = new Session();
        $session->getFlashBag()->add('success', "Type de vin \"" . $wineType->getName() . "\" supprimé");
        return $this->redirectToRoute('admin_product_wineType');
    }

    /**
     * @Route("capacite", name="capacity")
     */
    public function capacity(Request $request, CapacityManager $capacityManager)
    {
        $form = $this->createForm(CapacityType::class, new Capacity());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $capacityManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Capacité Ajoutée");
        }

        return $this->render('admin/page/product/capacity.html.twig',
            [
                'capacities' => $this->getDoctrine()->getRepository(Capacity::class)->findAll(),
                'form' => $form->createView(),
                'action' => 'add'
            ]);
    }

    /**
     * @Route("capacity/{capacityId}", name="capacity_update")
     */
    public function capacity_update(Request $request, CapacityManager $capacityManager, $capacityId)
    {
        $capacity = $this->getDoctrine()->getRepository(Capacity::class)->find($capacityId);

        if (!$capacity) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver la cuvée n°' . $capacityId);
            return $this->redirectToRoute('admin_product_capacity');
        }

        $form = $this->createForm(CapacityType::class, $capacity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $capacityManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Capacité modifiée");
            return $this->redirectToRoute('admin_product_capacity');
        }

        return $this->render('admin/page/product/capacity.html.twig',
            [
                'capacities' => $this->getDoctrine()->getRepository(Capacity::class)->findAll(),
                'form' => $form->createView(),
                'action' => 'update'
            ]);
    }

    /**
     * @Route("capacity/{capacityId}/delete", name="capacity_delete")
     */
    public function capacity_delete(CapacityManager $capacityManager, $capacityId)
    {
        $capacity = $this->getDoctrine()->getRepository(Capacity::class)->find($capacityId);

        if (!$capacity) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver la capacité n°' . $capacityId);
            return $this->redirectToRoute('admin_product_capacity');
        }

        $capacityManager->delete($capacity);
        $session = new Session();
        $session->getFlashBag()->add('success', "Capacité \"" . $capacity->getName() . "\" supprimé");
        return $this->redirectToRoute('admin_product_capacity');
    }

    /**
     * @Route("millesime", name="vintage")
     */
    public function vintage(Request $request, VintageManager $vintageManager)
    {
        $form = $this->createForm(VintageType::class, new Vintage());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vintageManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Millésime Ajouté");
        }

        return $this->render('admin/page/product/vintage.html.twig',
            [
                'vintages' => $this->getDoctrine()->getRepository(Vintage::class)->findBy(
                    [],
                    [
                        'priority' => 'DESC'
                    ]
                ),
                'form' => $form->createView(),
                'action' => 'add'
            ]);
    }

    /**
     * @Route("millesime/{vintageId}", name="vintage_update")
     */
    public function vintage_update(Request $request, VintageManager $vintageManager, $vintageId)
    {
        $vintage = $this->getDoctrine()->getRepository(Vintage::class)->find($vintageId);

        if (!$vintage) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver la cuvée n°' . $vintageId);
            return $this->redirectToRoute('admin_product_vintage');
        }

        $form = $this->createForm(VintageType::class, $vintage);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vintageManager->add($form->getData());
            $session = new Session();
            $session->getFlashBag()->add('success', "Millésime modifié");
            return $this->redirectToRoute('admin_product_vintage');
        }

        return $this->render('admin/page/product/vintage.html.twig',
            [
                'vintages' => $this->getDoctrine()->getRepository(Vintage::class)->findBy(
                    [],
                    [
                        'priority' => 'DESC'
                    ]
                ),
                'form' => $form->createView(),
                'action' => 'update'
            ]);
    }

    /**
     * @Route("millesime/{vintageId}/delete", name="vintage_delete")
     */
    public function vintage_delete(VintageManager $vintageManager, $vintageId)
    {
        $vintage = $this->getDoctrine()->getRepository(Vintage::class)->find($vintageId);

        if (!$vintage) {
            $session = new Session();
            $session->getFlashBag()->add('danger', 'Impossible de retrouver le millésime n°' . $vintageId);
            return $this->redirectToRoute('admin_product_vintage');
        }

        $vintageManager->delete($vintage);
        $session = new Session();
        $session->getFlashBag()->add('success', "Millésime \"" . $vintage->getName() . "\" supprimé");
        return $this->redirectToRoute('admin_product_vintage');
    }
}