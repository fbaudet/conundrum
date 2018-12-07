<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConundrumController extends AbstractController
{
    /**
     * @Route("/", name="app_homepage")
     */
    public function index()
    {
        return $this->render('conundrum/index.html.twig', [
            'controller_name' => 'ConundrumController',
        ]);
    }

    /**
     * @Route("/steps", name="app_steps")
     * @IsGranted("ROLE_USER")
     */
    public function steps()
    {
        return $this->render('conundrum/steps.html.twig');
    }
}
