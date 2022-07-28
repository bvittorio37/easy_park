<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Entity\Portefeuil;
use App\Entity\Utilisateur;
use App\Repository\DemandeRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin')]
class AdminController extends AbstractController
{
    #[Route('/', name: 'admin.acceuil')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/valider/{id}', name: 'admin.valider')]
    public function valider(Demande $demande,ManagerRegistry $doctrine,DemandeRepository $demandeRepository): Response
    {
        $entityManger = $doctrine->getManager();
        $portefeuil= $demande->getClient()->getPortefeuil(); 
        
        if($portefeuil !== null){
            $nouvSolde = $portefeuil->getSolde() + $demande->getSomme();
            $portefeuil->setSolde($nouvSolde);
            
            
        }
        else{
            $portefeuil= new Portefeuil();
            $portefeuil->setClient($demande->getClient());
            $portefeuil->setSolde($demande->getSomme());
        }
        //dd($portefeuil);
        $entityManger->persist($portefeuil);
        $entityManger->flush();
        $demandeRepository->remove($demande, true);
        return $this->redirectToRoute('app_demande_index', [], Response::HTTP_SEE_OTHER);
    }
    
}
