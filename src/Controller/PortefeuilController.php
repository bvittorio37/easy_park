<?php

namespace App\Controller;

use App\Entity\Portefeuil;
use App\Form\PortefeuilType;
use App\Repository\PortefeuilRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/portefeuil')]
class PortefeuilController extends AbstractController
{
    #[Route('/', name: 'app_portefeuil_index', methods: ['GET'])]
    public function index(PortefeuilRepository $portefeuilRepository): Response
    {
        return $this->render('portefeuil/index.html.twig', [
            'portefeuils' => $portefeuilRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_portefeuil_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PortefeuilRepository $portefeuilRepository): Response
    {
        $portefeuil = new Portefeuil();
        $form = $this->createForm(PortefeuilType::class, $portefeuil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $portefeuilRepository->add($portefeuil, true);

            return $this->redirectToRoute('app_portefeuil_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('portefeuil/new.html.twig', [
            'portefeuil' => $portefeuil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portefeuil_show', methods: ['GET'])]
    public function show(Portefeuil $portefeuil): Response
    {
        return $this->render('portefeuil/show.html.twig', [
            'portefeuil' => $portefeuil,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_portefeuil_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Portefeuil $portefeuil, PortefeuilRepository $portefeuilRepository): Response
    {
        $form = $this->createForm(PortefeuilType::class, $portefeuil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $portefeuilRepository->add($portefeuil, true);

            return $this->redirectToRoute('app_parking_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('portefeuil/edit.html.twig', [
            'portefeuil' => $portefeuil,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_portefeuil_delete', methods: ['POST'])]
    public function delete(Request $request, Portefeuil $portefeuil, PortefeuilRepository $portefeuilRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$portefeuil->getId(), $request->request->get('_token'))) {
            $portefeuilRepository->remove($portefeuil, true);
        }

        return $this->redirectToRoute('app_portefeuil_index', [], Response::HTTP_SEE_OTHER);
    }
}
