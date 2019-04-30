<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_homepage")
     * @IsGranted("ROLE_ADMIN")
     */
    public function admin()
    {
        return $this->render('admin/index.html.twig');
    }
}
