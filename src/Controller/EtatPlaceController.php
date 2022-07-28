<?php

namespace App\Controller;

use App\Entity\EtatPlace;
use App\Form\EtatPlaceType;
use App\Repository\EtatPlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/etat/place')]
class EtatPlaceController extends AbstractController
{
    #[Route('/', name: 'app_etat_place_index', methods: ['GET'])]
    public function index(EtatPlaceRepository $etatPlaceRepository): Response
    {
        return $this->render('etat_place/index.html.twig', [
            'etat_places' => $etatPlaceRepository->findAll(),
        ]);
    }

    #[Route('/desactiver', name: 'app_etat_place_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EtatPlaceRepository $etatPlaceRepository): Response
    {
        $etatPlace = new EtatPlace();
        $form = $this->createForm(EtatPlaceType::class, $etatPlace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etatPlaceRepository->add($etatPlace, true);

            return $this->redirectToRoute('app_etat_place_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etat_place/new.html.twig', [
            'etat_place' => $etatPlace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etat_place_show', methods: ['GET'])]
    public function show(EtatPlace $etatPlace): Response
    {
        return $this->render('etat_place/show.html.twig', [
            'etat_place' => $etatPlace,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_etat_place_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, EtatPlace $etatPlace, EtatPlaceRepository $etatPlaceRepository): Response
    {
        $form = $this->createForm(EtatPlaceType::class, $etatPlace);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $etatPlaceRepository->add($etatPlace, true);

            return $this->redirectToRoute('app_etat_place_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('etat_place/edit.html.twig', [
            'etat_place' => $etatPlace,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_etat_place_delete', methods: ['POST'])]
    public function delete(Request $request, EtatPlace $etatPlace, EtatPlaceRepository $etatPlaceRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$etatPlace->getId(), $request->request->get('_token'))) {
            $etatPlaceRepository->remove($etatPlace, true);
        }

        return $this->redirectToRoute('app_etat_place_index', [], Response::HTTP_SEE_OTHER);
    }
}
