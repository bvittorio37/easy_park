<?php

namespace App\Controller;

use App\Entity\Historique;
use App\Entity\Parking;
use App\Entity\Place;
use App\Entity\Portefeuil;
use App\Form\ParkingType;
use App\Repository\DatenowRepository;
use App\Repository\HistoriqueRepository;
use App\Repository\ParkingRepository;
use App\Repository\PlaceRepository;
use App\Repository\PortefeuilRepository;
use App\Service\ControleService;
use App\Service\ServiceAlea;
use App\Service\DateNowService;
use App\Service\HistoriqueService;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/parking')]
class ParkingController extends AbstractController
{
    #[Route('/', name: 'app_parking_index', methods: ['GET'])]
    public function index(ParkingRepository $parkingRepository,HistoriqueRepository $ripo): Response
    {
        
             
       
        return $this->render('parking/index.html.twig', [
            'parkings' => $this->getUser()->getParkings()
        ]);
    }
    
    #[Route('/ajout', name: 'app_parking_new', methods: ['GET', 'POST'])]
    public function new(Request $request,HistoriqueRepository $ripo,DatenowRepository  $dateRepo,ManagerRegistry $doctrine, Session $session,ControleService $controle,HistoriqueService $histoSere,DateNowService $dateServe): Response
    {
       /*  if(!$dateRepo->getDefaultValue()){
            $getnow=date_create(date("H:i:s"));
        }
        else{
            $getnow=$dateRepo->getDefaultValue()[0]->getDatenow();
        } */
        $getnow = $this->dateServe->getNow();
        $parking = new Parking();
        $form = $this->createForm(ParkingType::class, $parking);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            

            $entityManager = $doctrine->getManager();
            $parking->setClient($this->getUser());

           // dd($parking->getMatricule());
         
             if($histoSere->chercherHistoriqueMatricule($parking->getMatricule()) ){
                return $this->renderForm('parking/new.html.twig', [
                    'parking' => $parking,
                    'form' => $form,
                    'datenow'=> $getnow,
                    'message'=> 'Efa INFRACTION 3 ZAY NO NATAONLAH',
                ]);
            } 
           // dd($parking->getDebut());
            //////////// Controleur Portefeuil ////////////////
            $prix= $parking->getTarif()->getPrix() ;
            $solde=$parking->getClient()->getPortefeuil()->getSolde();
            $dateDebut=$parking->getDebut();
            $prix = $controle->isRemise($dateDebut,$prix);
            
            $prix = $controle->isDeduction($dateDebut,$prix,$solde);
        
            
            if($prix > $solde)
            {
                return $this->renderForm('parking/new.html.twig', [
                    'parking' => $parking,
                    'form' => $form,
                    'datenow'=> $getnow,
                ]);
                    
            }
            $portefeuil = new Portefeuil();
            $portefeuil->soustractionService($parking->getClient(), $solde, $prix );
           // dd($portefeuil->getSolde());
            $entityManager->persist($parking);
            $entityManager->flush();
            /* $entityManager->persist($portefeuil);
           */
            $session->set('portefeuil', $portefeuil);
            return $this->redirectToRoute('app_portefeuil_edit', ['id'=> $portefeuil->getId()], Response::HTTP_SEE_OTHER);
        }
        return $this->renderForm('parking/new.html.twig', [
            'parking' => $parking,
            'form' => $form,
            'datenow'=> $getnow,
        ]);
    }
   
    /* #[Route('/', name: 'app_parking_index', methods: ['GET'])]
    public function index(ParkingRepository $parkingRepository): Response
    {
        return $this->render('parking/index.html.twig', [
            'parkings' => $parkingRepository->findAll(),
        ]);
    } */
 /* #[Route('/', name: 'app_parking_index', methods: ['GET'])]
    public function index(ParkingRepository $parkingRepository,ManagerRegistry $doctrine): Response
    {
        N
        $entityManager = $doctrine->getManager();
        $parking->setClient($this->getUser());
        $parking->setPlace($session->get('place'));
        $parking->setDebut(date_create(date('Y-m-d H:i:s')));
        
        $entityManager->persist($parking);
        $entityManager->flush();
        return $this->render('parking/index.html.twig', [
            'parkings' => $parkingRepository->findAll(),
        ]);
    }  */
   
/* 
    #[Route('/{id}', name: 'app_parking_show', methods: ['GET'])]
    public function show(Parking $parking): Response
    {   $dateNow = date_create(date("H:i:s"));
        $retour =array();
        dd( $retour); */
       /*  $dateNow = date_create(date("H:i:s"));
       
        $heureTarif = date_create("12:00:00");
        $datedebutFormat= date_format(date_create("1995-07-14 06:00:00"),"H:i:s");
        $datedebut=date_create($datedebutFormat);
        $h = date_format($heureTarif,"H");
        $s =date_format($heureTarif,"s");
        $m =date_format($heureTarif,"i");
        //date_add($datedebut,date_interval_create_from_date_string($h."hours"." ".$m." min"." ".$s."sec"));
        //$datedebut= date_format($parking->getDebut(),"H:i:s");
        $datePrevut = date_add($datedebut,date_interval_create_from_date_string($h."hours"." ".$m." min"." ".$s."sec"));
        $restant= date_diff($dateNow,$datePrevut);
        dd($restant); */

      /*   return $this->render('parking/show.html.twig', [
            'parking' => $parking,
        ]);
    } */

    


     #[Route('/{id}/edit', name: 'app_parking_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Parking $parking, ParkingRepository $parkingRepository): Response
    {
        $form = $this->createForm(ParkingType::class, $parking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parking->setDebut( date_create(date("H:i:s")));
            $parkingRepository->add($parking, true);
            return $this->redirectToRoute('app_parking_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->renderForm('parking/edit.html.twig', [
            'parking' => $parking,
            'form' => $form,
        ]);
        
    } 
    #[Route('/{id}', name: 'app_parking_delete', methods: ['GET'])]
    public function delete( Parking $parking, ParkingRepository $parkingRepository,DateNowService $dateServe,HistoriqueRepository $historiqueRepository,DatenowRepository $daty): Response
    {   
            $historique = new Historique;
            $historique->setPlace($parking->getPlace());
            $historique->setClient($parking->getClient());
            $historique->setTarif($parking->getTarif());
            $historique->setMatricule($parking->getMatricule());
            $historique->setDebut($parking->getDebut());
            $historique->setDePart($dateServe->getNow($daty));

            $historiqueRepository->add($historique, true);

            $parkingRepository->remove($parking, true);
      
        return $this->redirectToRoute('app_parking_index', [], Response::HTTP_SEE_OTHER);
    } 
     
}
