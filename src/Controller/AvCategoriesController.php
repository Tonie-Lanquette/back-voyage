<?php

namespace App\Controller;

use App\Entity\AvCategories;
use App\Form\AvCategoriesType;
use App\Repository\AvCategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/av/categor')]
class AvCategoriesController extends AbstractController
{
    #[Route('ies', name: 'app_av_categories_index', methods: ['GET'])]
    public function index(AvCategoriesRepository $avCategoriesRepository): Response
    {
        return $this->render('av_categories/index.html.twig', [
            'av_categories' => $avCategoriesRepository->findAll(),
        ]);
    }

    #[Route('y/new', name: 'app_av_categories_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $avCategory = new AvCategories();
        $form = $this->createForm(AvCategoriesType::class, $avCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_av_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('av_categories/new.html.twig', [
            'av_category' => $avCategory,
            'form' => $form,
        ]);
    }

    #[Route('y/{name}', name: 'app_av_categories_show', methods: ['GET'])]
    public function show(AvCategories $avCategory): Response
    {
        return $this->render('av_categories/show.html.twig', [
            'av_category' => $avCategory,
        ]);
    }

    #[Route('y/{name}/edit', name: 'app_av_categories_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AvCategories $avCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvCategoriesType::class, $avCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_av_categories_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('av_categories/edit.html.twig', [
            'av_category' => $avCategory,
            'form' => $form,
        ]);
    }

    #[Route('y/{name}', name: 'app_av_categories_delete', methods: ['POST'])]
    public function delete(Request $request, AvCategories $avCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avCategory->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($avCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_av_categories_index', [], Response::HTTP_SEE_OTHER);
    }
}
