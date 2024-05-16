<?php

namespace App\Controller;

use App\Entity\AvBooking;
use App\Form\AvBookingType;
use App\Repository\AvBookingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/av/booking')]
class AvBookingController extends AbstractController
{
    #[Route('s', name: 'app_av_booking_index', methods: ['GET'])]
    public function index(AvBookingRepository $avBookingRepository): Response
    {
        return $this->render('av_booking/index.html.twig', [
            'av_bookings' => $avBookingRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_av_booking_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $avBooking = new AvBooking();
        $form = $this->createForm(AvBookingType::class, $avBooking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($avBooking);
            $entityManager->flush();

            return $this->redirectToRoute('app_av_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('av_booking/new.html.twig', [
            'av_booking' => $avBooking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_av_booking_show', methods: ['GET'])]
    public function show(AvBooking $avBooking): Response
    {
        return $this->render('av_booking/show.html.twig', [
            'av_booking' => $avBooking,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_av_booking_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, AvBooking $avBooking, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(AvBookingType::class, $avBooking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_av_booking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('av_booking/edit.html.twig', [
            'av_booking' => $avBooking,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_av_booking_delete', methods: ['POST'])]
    public function delete(Request $request, AvBooking $avBooking, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$avBooking->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($avBooking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_av_booking_index', [], Response::HTTP_SEE_OTHER);
    }
}
