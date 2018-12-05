<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ConundrumController extends AbstractController
{
    /**
     * @Route("/", name="conundrum")
     */
    public function index()
    {
        return $this->render('conundrum/index.html.twig', [
            'controller_name' => 'ConundrumController',
        ]);
    }
}
