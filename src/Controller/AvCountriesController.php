<?php

namespace App\Controller;

use App\Entity\AvCountries;
use App\Form\AvCountriesType;
use App\Repository\AvCountriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/av/countr')]
class AvCountriesController extends AbstractController
{
    #[Route('ies', name: 'app_av_countries_index', methods: ['GET'])]
    public function index(AvCountriesRepository $avCountriesRepository): Response
    {
        return $this->render('av_countries/index.html.twig', [
            'av_countries' => $avCountriesRepository->findAll(),
        ]);
    }

    #[Route('y/new', name: 'app_av_countries_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $avCountry = new AvCountries();
        $form = $this->createForm(AvCountriesType::class, $avCountry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avCountry);
            $entityManager->flush();

            return $this->redirectToRoute('app_av_countries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('av_countries/new.html.twig', [
            'av_country' => $avCountry,
            'form' => $form,
        ]);
    }

    #[Route('y/{name}', name: 'app_av_countries_show', methods: ['GET'])]
    public function show(AvCountries $avCountry): Response
    {
        return $this->render('av_countries/show.html.twig', [
            'av_country' => $avCountry,
        ]);
    }

    #[Route('y/{name}/edit', name: 'app_av_countries_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AvCountries $avCountry, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvCountriesType::class, $avCountry);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_av_countries_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('av_countries/edit.html.twig', [
            'av_country' => $avCountry,
            'form' => $form,
        ]);
    }

    #[Route('y/{name}', name: 'app_av_countries_delete', methods: ['POST'])]
    public function delete(Request $request, AvCountries $avCountry, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avCountry->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($avCountry);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_av_countries_index', [], Response::HTTP_SEE_OTHER);
    }
}
