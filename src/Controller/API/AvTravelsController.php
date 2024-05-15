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

    #[Route('/image/{name}', name: 'api_av_travels_image')]
    public function image(AvTravels $avTravels)
    {

        return $this->json($avTravels, context: ['groups' => 'api_av_travels_image']);
    }
    
    #[Route('/{name}', name: 'api_av_travels_show')]
    public function show(AvTravels $avTravels)
    {
       
        return $this->json($avTravels, context: ['groups' => 'api_av_travels_index', 'api_av_travels_show']);
    }

    
}
