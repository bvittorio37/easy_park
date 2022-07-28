<?php

namespace App\Controller;

use App\Entity\DateDefault;
use App\Entity\Place;
use App\Form\PlaceType;
use App\Repository\DatenowRepository;
use App\Repository\PlaceRepository;
use App\Service\DateNowService;
use App\Service\PdfService;
use stdClass;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/place')]
class PlaceController extends AbstractController
{
    #[Route('/', name: 'app_place_index', methods: ['GET'])]
    public function index(PlaceRepository $placeRepository,DatenowRepository $dateRepo,DateNowService $dateServ): Response
    {
         $getnow=$dateServ->getNow();
        /* if(!$dateRepo->getDefaultValue()){
            $getnow=date_create(date("H:i:s"));
        }
        else{
            $getnow=$dateRepo->getDefaultValue()[0]->getDatenow();
        } */
       
        $service= new DateDefault();
        
        $genericObject =$service->getPlaceDisponible($getnow, $placeRepository->findAll()); //new stdClass();
        
        return $this->render('place/index.html.twig', [
            'places' => $genericObject,
            'datenow'=> $getnow,
        ]);
    }

    #[Route('/new', name: 'app_place_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PlaceRepository $placeRepository): Response
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $placeRepository->add($place, true);

            return $this->redirectToRoute('app_place_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('place/new.html.twig', [
            'place' => $place,
            'form' => $form,
        ]);
    }

    #[Route('/ajout-parking/{id}', name: 'parking_redirection', methods: ['GET', 'POST'],options: ['expose' => true])]
    public function rediriger(Request $request,Place $place, PlaceRepository $placeripo,Session $session): Response
    {    
        $session->set('place',$place);
    
        return $this->redirectToRoute('app_parking_new', [], Response::HTTP_SEE_OTHER);
    }



    #[Route('/{id}', name: 'app_place_show', methods: ['GET'])]
    public function show(Place $place): Response
    {
        return $this->render('place/show.html.twig', [
            'place' => $place,
        ]);
    }

    

    #[Route('/{id}/edit', name: 'app_place_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Place $place, PlaceRepository $placeRepository): Response
    {
        $form = $this->createForm(PlaceType::class, $place);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $placeRepository->add($place, true);

            return $this->redirectToRoute('app_place_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('place/edit.html.twig', [
            'place' => $place,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_place_delete', methods: ['POST'])]
    public function delete(Request $request, Place $place, PlaceRepository $placeRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$place->getId(), $request->request->get('_token'))) {
            $placeRepository->remove($place, true);
        }

        return $this->redirectToRoute('app_place_index', [], Response::HTTP_SEE_OTHER);
    }
}
