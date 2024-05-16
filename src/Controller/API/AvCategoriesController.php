<?php

namespace App\Controller\API;

use App\Repository\AvCategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/av/categor', name: 'api_av_categories_')]
class AvCategoriesController extends AbstractController
{

    #[Route('ies', name: 'api_av_categories_index')]
    public function index(AvCategoriesRepository $avCategoriesRepository)
    {
        $categories = $avCategoriesRepository->findAll();
        return $this->json($categories, context: ['groups' => 'api_av_categories_index']);
    }
}
