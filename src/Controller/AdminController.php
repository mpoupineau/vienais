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

class AdminController extends AbstractController
{

    /**
     * @Route("/admin/home", name="admin_home")
     */
    public function home()
    {
        return $this->render('admin/base.html.twig');
    }

    /**
     * @Route("/admin/exemple", name="admin_exemple")
     */
    public function exemple()
    {
        return $this->render('admin/page/exemple.html.twig');
    }

    /**
     * @Route("/admin/", name="admin_dashboard")
     */
    public function dashboard()
    {
        return $this->render('admin/page/dashboard.html.twig');
    }
}