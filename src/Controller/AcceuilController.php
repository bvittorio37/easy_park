<?php

namespace App\Controller;

use App\Entity\DateDefault;
use App\Entity\Place;
use App\Repository\DatenowRepository;
use App\Repository\PlaceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilController extends AbstractController
{
    #[Route('/', name: 'app_acceuil')]
    public function index(): Response
    {
        return $this->redirectToRoute('app_place_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/elemtentplace/{id}', name: 'acceuil.element',options: ['expose' => true])]
    public function getElementPlace(Place $place,Request $request,DatenowRepository $dateRepo): Response
    {
        if ($request->isXmlHttpRequest()|| $request->query->get('showJson') == 1) {

                $dd = new DateDefault();
               
                    if(!$dateRepo->getDefaultValue()){
                        $getnow= date_create(date("H:i:s"));
                    }
                    else{
                        $getnow=$dateRepo->getDefaultValue()[0]->getDatenow();
                    }
                    
                $informations = $dd->getIntervalParPlace($getnow,$place);
               $temp = array(
                'idplace'=> $place->getId(),
                'etat'=> $informations->getEtat() ,
                'nopark' =>  $place->getNoPark(),
                'datearrive'=> null,
                'durree'=>null,
                'numero'=>null,
                'restant'=>null
               );
               if($informations->getEtat() == "Desactive"){
                return new JsonResponse($temp);
               } 
               if($informations->getEtat() != "Libre"  ){
                $temp['datearrive']=$place->getParking()->getDebut()->format('H:i:s  d/F/Y') ;
                $temp['durree']=$place->getParking()->getTarif()->getTemps()->format('H:i:s');
                $temp['numero']=$place->getParking()->getMatricule();
                $temp['restant']=$informations->getJour();
                $temp['tarif'] = $place->getParking()->getTarif()->__toString();

               }
               
                 
           
            return new JsonResponse($temp); 
            } 
        
       return $this->render('acceuil/index.html.twig', [
            
        ]);
    }
}


    

