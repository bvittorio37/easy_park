<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Repository\ParkingRepository;
use App\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/export')]
class ParkController extends AbstractController
{
    #[Route('/{id}', name: 'app_parking_show', methods: ['GET'])]
    public function show(Parking $parking): Response
    {   
       
        return $this->render('parking/show.html.twig', [
            'parking' => $parking,
        ]);
    }

   
}
