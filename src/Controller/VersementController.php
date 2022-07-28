<?php

namespace App\Controller;

use App\Entity\Demande;
use App\Repository\DemandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VersementController extends AbstractController
{
    #[Route('/versement', name: 'app_versement')]
    public function index(): Response
    {
        return $this->render('versement/index.html.twig', [
            
            'controller_name' => 'VersementController',
        ]);
    }

    
}
