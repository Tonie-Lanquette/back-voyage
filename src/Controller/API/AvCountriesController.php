<?php

namespace App\Controller\API;


use App\Repository\AvCountriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/api/av/countr', name: 'api_av_countries_')]
class AvCountriesController extends AbstractController
{

#[Route('ies', name: 'api_av_countries_index')]
public function index(AvCountriesRepository $avCountriesRepository)
{
$countries = $avCountriesRepository->findAll();
return $this->json($countries, context: ['groups' => 'api_av_countries_index']);
}


}