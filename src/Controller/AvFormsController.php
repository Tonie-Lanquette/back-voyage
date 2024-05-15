<?php

namespace App\Controller;

use App\Entity\AvForms;
use App\Form\AvFormsType;
use App\Repository\AvFormsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/av/form')]
class AvFormsController extends AbstractController
{
    #[Route('s', name: 'app_av_forms_index', methods: ['GET'])]
    public function index(AvFormsRepository $avFormsRepository): Response
    {
        return $this->render('av_forms/index.html.twig', [
            'av_forms' => $avFormsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_av_forms_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $avForm = new AvForms();
        $form = $this->createForm(AvFormsType::class, $avForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avForm);
            $entityManager->flush();

            return $this->redirectToRoute('app_av_forms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('av_forms/new.html.twig', [
            'av_form' => $avForm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_av_forms_show', methods: ['GET'])]
    public function show(AvForms $avForm): Response
    {
        return $this->render('av_forms/show.html.twig', [
            'av_form' => $avForm,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_av_forms_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AvForms $avForm, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvFormsType::class, $avForm);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_av_forms_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('av_forms/edit.html.twig', [
            'av_form' => $avForm,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_av_forms_delete', methods: ['POST'])]
    public function delete(Request $request, AvForms $avForm, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avForm->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($avForm);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_av_forms_index', [], Response::HTTP_SEE_OTHER);
    }
}
