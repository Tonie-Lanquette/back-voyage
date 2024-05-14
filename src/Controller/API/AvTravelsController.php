<?php

namespace App\Controller\API;

use App\Repository\AvTravelsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

// #[Route('/api/av/travel', name: 'api_av_travels_')]
class AvTravelsController extends AbstractController
{

    #[Route('/api/av/travels', name: 'api_av_travels_index')]
    public function index(AvTravelsRepository $avTravelsRepository)
    {
        $travels = $avTravelsRepository->findAll();
        return $this->json($travels, 200, context: ['groups' => 'api_av_travels_index']);
    }

    #[Route('/api/av/travel/{id}', name: 'api_av_travels_show')]
    public function show(AvTravelsRepository $avTravelsRepository)
    {
        $travels = $avTravelsRepository->findAll();
        return $this->json($travels, 200, context: ['groups' => 'api_av_travels_index', 'api_av_travels_show']);
    }
}
