<?php

namespace App\Controller;

use App\Entity\AvTravels;
use App\Form\AvTravelsType;
use App\Repository\AvTravelsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/av/travel')]
class AvTravelsController extends AbstractController
{
    #[Route('s', name: 'app_av_travels_index', methods: ['GET'])]
    public function index(AvTravelsRepository $avTravelsRepository): Response
    {
        return $this->render('av_travels/index.html.twig', [
            'av_travels' => $avTravelsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_av_travels_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, Security $security): Response
    {
        $avTravel = new AvTravels();

        $user = $security->getUser();
        $avTravel->setAvUser($user);

        $form = $this->createForm(AvTravelsType::class, $avTravel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avTravel);
            $entityManager->flush();

            return $this->redirectToRoute('app_av_travels_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('av_travels/new.html.twig', [
            'av_travel' => $avTravel,
            'form' => $form,
        ]);
    }

    #[Route('/{name}', name: 'app_av_travels_show', methods: ['GET'])]
    public function show(AvTravels $avTravel): Response
    {
        return $this->render('av_travels/show.html.twig', [
            'av_travel' => $avTravel,
        ]);
    }

    #[Route('/{name}/edit', name: 'app_av_travels_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AvTravels $avTravel, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvTravelsType::class, $avTravel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_av_travels_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('av_travels/edit.html.twig', [
            'av_travel' => $avTravel,
            'form' => $form,
        ]);
    }

    #[Route('/{name}', name: 'app_av_travels_delete', methods: ['POST'])]
    public function delete(Request $request, AvTravels $avTravel, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avTravel->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($avTravel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_av_travels_index', [], Response::HTTP_SEE_OTHER);
    }
}
