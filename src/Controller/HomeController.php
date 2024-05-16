<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/av/home', name: 'app_av_home')]
    public function index(): Response
    {
        return $this->render('av_home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}