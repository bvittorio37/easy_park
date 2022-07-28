<?php
nameSpace App\Service;

use App\Entity\Historique;
use App\Entity\Parking;

class TicketService
{
    private $ammendeServe;
    private $histoServe;
    private $parkServe;
    public function __construct(ParkingService $parkServe,ControleAmmende $ammendeServe,HistoriqueService $histoServe)
    {
        $this->parkServe=$parkServe;
        $this->ammendeServe=$ammendeServe;
        $this->histoServe=$histoServe;
    }
    public function getEtatParking(Parking $parking)
    {
        
        if($this->parkServe->parkingEstEnAmmende($parking) ){
           return $this->ammendeServe->getAmmende();
        }
        return 0;
    }
    public function getEtatHistorique(Historique $historique){
        if($this->histoServe->misyAmmendeVe($historique) ){
            return $this->ammendeServe->ammende;
        }
        return 0;
    }

}


?>