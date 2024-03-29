<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Form\HistoriqueType;
use App\Repository\HistoriqueRepository;
use App\Repository\DatenowRepository;
use App\Repository\ParkingRepository;
use App\Service\ControleAmmende;
use App\Service\DateNowService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/historique')]
class HistoriqueController extends AbstractController
{
    #[Route('/', name: 'app_historique_index', methods: ['GET'])]
    public function index(HistoriqueRepository $historiqueRepository,ParkingRepository $parkRipo, ControleAmmende $controle,DateNowService $nowServ,DatenowRepository $dateRipo): Response
    {
        $listeHistorique = $controle->getHistoriqueEtAmmende();
        $listeParking =  $controle->getParkingEtAmmende();
       // dd($listeParking);
        return $this->render('historique/index.html.twig', [
            'historiques' => $listeHistorique,
            'parkings'=>$listeParking,
        ]);
    }

    #[Route('/new', name: 'app_historique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HistoriqueRepository $historiqueRepository): Response
    {
        $historique = new Historique();
        $form = $this->createForm(HistoriqueType::class, $historique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $historiqueRepository->add($historique, true);

            return $this->redirectToRoute('app_historique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('historique/new.html.twig', [
            'historique' => $historique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_historique_show', methods: ['GET'])]
    public function show(Historique $historique): Response
    {
        return $this->render('historique/show.html.twig', [
            'historique' => $historique,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_historique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Historique $historique, HistoriqueRepository $historiqueRepository): Response
    {
        $form = $this->createForm(HistoriqueType::class, $historique);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $historiqueRepository->add($historique, true);

            return $this->redirectToRoute('app_historique_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('historique/edit.html.twig', [
            'historique' => $historique,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_historique_delete', methods: ['POST'])]
    public function delete(Request $request, Historique $historique, HistoriqueRepository $historiqueRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$historique->getId(), $request->request->get('_token'))) {
            $historiqueRepository->remove($historique, true);
        }

        return $this->redirectToRoute('app_historique_index', [], Response::HTTP_SEE_OTHER);
    }
}
