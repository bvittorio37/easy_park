<?php
nameSpace App\Service;

use App\Entity\Parking;
use App\Repository\HistoriqueRepository;
use App\Repository\ParkingRepository;

Class ControleAmmende
{
   
    private $ammende;
    private $parkRipo;
    private $histoRepo;
    private $histoServe;
    private $dateNow;
    
    public function __construct(ParkingRepository $parkRipo,HistoriqueRepository $histoRepo,
            HistoriqueService $histoServe,DateNowService $dateNow)
    {
      $this->ammende=100000;
      $this->parkRipo=$parkRipo;
      $this->histoRepo=$histoRepo;
      $this->histoServe=$histoServe;
      $this->dateNow = $dateNow;
    }
    public function getAmmende(){
        return $this->ammende;
    }
   
    public function getParkingEtAmmende(){
       // dd($this->dateNow);
        $liste = $this->parkRipo->findAll();
        foreach ($liste as $parking){
            $diff_fin= date_diff($this->dateNow->getNow(),$parking->getDateFin());
            if( $diff_fin->invert==1  ){
                $parking->setAmmende($this->ammende);
            }  
         }
         return $liste;
    }
    public function getHistoriqueEtAmmende(){
        $liste = $this->histoRepo->findAll();
        foreach ($liste as $historique){
           if($this->histoServe->misyAmmendeVe($historique)){
                $historique->setAmmende($this->ammende);
           }
         }
         return $liste;
    }
    
 

}