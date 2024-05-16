<?php

namespace App\Controller\API;

use App\Entity\AvTravels;
use App\Repository\AvTravelsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/av/travel', name: 'api_av_travels_')]
class AvTravelsController extends AbstractController
{

    #[Route('s', name: 'api_av_travels_index')]
    public function index(AvTravelsRepository $avTravelsRepository)
    {
        $travels = $avTravelsRepository->findAll();
        return $this->json($travels,  context: ['groups' => 'api_av_travels_index']);
    }

    #[Route('s/show', name: 'api_av_travels_show')]
    public function show(AvTravelsRepository $avTravelsRepository)
    {
        $travels = $avTravelsRepository->findAll();
        return $this->json($travels, context: ['groups' =>['api_av_travels_show' ,'api_av_travels_index'] ]);
    }

    
}
