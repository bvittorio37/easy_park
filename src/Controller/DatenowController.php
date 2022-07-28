<?php

namespace App\Controller;

use App\Entity\Datenow;
use App\Form\DatenowType;
use App\Repository\DatenowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/datenow')]
class DatenowController extends AbstractController
{
    #[Route('/', name: 'app_datenow_index', methods: ['GET'])]
    public function index(DatenowRepository $datenowRepository): Response
    {
        return $this->render('datenow/index.html.twig', [
            'datenows' => $datenowRepository->getDefaultValue(),
        ]);
    }

    #[Route('/new', name: 'app_datenow_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DatenowRepository $datenowRepository): Response
    {
        $datenow = new Datenow();
        $form = $this->createForm(DatenowType::class, $datenow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datenowRepository->add($datenow, true);

            return $this->redirectToRoute('app_datenow_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('datenow/new.html.twig', [
            'datenow' => $datenow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_datenow_show', methods: ['GET'])]
    public function show(Datenow $datenow): Response
    {
        return $this->render('datenow/show.html.twig', [
            'datenow' => $datenow,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_datenow_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Datenow $datenow, DatenowRepository $datenowRepository): Response
    {
        $form = $this->createForm(DatenowType::class, $datenow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $datenowRepository->add($datenow, true);

            return $this->redirectToRoute('app_datenow_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('datenow/edit.html.twig', [
            'datenow' => $datenow,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_datenow_delete', methods: ['POST'])]
    public function delete(Request $request, Datenow $datenow, DatenowRepository $datenowRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$datenow->getId(), $request->request->get('_token'))) {
            $datenowRepository->remove($datenow, true);
        }

        return $this->redirectToRoute('app_datenow_index', [], Response::HTTP_SEE_OTHER);
    }
}
