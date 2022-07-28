<?php

namespace App\Controller;
use App\Entity\Parking;
use App\Service\ControleService;
use App\Service\ControleAmmende;
use App\Service\DateNowService;
use App\Repository\ParkingRepository;
use App\Repository\HistoriqueRepository;
use App\Repository\DatenowRepository ;
use App\Service\TicketService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    #[Route('/ticket/parking/{id}', name: 'ticket_parking')]
    public function index(Request $request,ParkingRepository $parkRipo,ControleService $controle,TicketService $ticketServe): Response
    {
        $parking =$parkRipo->find($request->get('id'));
        $ammende= $ticketServe->getEtatParking($parking)  ;
        $remise= $controle->estRemise($parking->getDebut(),$parking->getTarif()->getPrix());
        $deduction=$controle->estDeduction($parking->getDebut(),$parking->getTarif()->getPrix());
        $gratuit =$controle->estGratuit($parking->getDebut(),$parking->getTarif());
       // dd($gratuit);
       // dd($parking);
        return $this->render('ticket/index.html.twig', [
            'element' => $parking,
            'ammende' =>$ammende,
            'remise'=>$remise,
            'deduction'=>$deduction,
            'gratuit'=>$gratuit,
            'indice'=>0,

        ]);
    }
    #[Route('/ticket/historique/{id}', name: 'ticket_historique')]
    public function historiqueTicket(Request $request,HistoriqueRepository $histoRipo,ControleService $controle,TicketService $ticketServe): Response
    {
        $historique =$histoRipo->find($request->get('id'));
        $ammende= $ticketServe->getEtatHistorique($historique)  ;
        $remise= $controle->estRemise($historique->getDebut(),$historique->getTarif()->getPrix());
        $deduction=$controle->estDeduction($historique->getDebut(),$historique->getTarif()->getPrix());
        $gratuit =$controle->estGratuit($historique->getDebut(),$historique->getTarif());
        
       // dd($parking);
        return $this->render('ticket/index.html.twig', [
            'element' => $historique,
            'ammende' =>$ammende,
            'remise'=>$remise,
            'deduction'=>$deduction,
            'gratuit'=>$gratuit,
            'indice'=>1,
        ]);
    }
   /*  #[Route('/pdf', name: 'ticket.pdf')]
    public function pdf(PdfService $pdf)
    {
        
        $html= $this->render('ticket/index.html.twig', [
            'controller_name' => 'TicketController', ]);
        $pdf->showPdfFile($html); 
         
    } */
}
