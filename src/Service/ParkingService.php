<?php 
nameSpace App\Service;

use App\Entity\Parking;

class ParkingService
{
    private $dateServe;
    
    public function __construct(DateNowService $dateServe)
    {
        $this->dateServe=$dateServe;
        
    }
    public function parkingEstEnAmmende(Parking $parking){
        /// Un parking est en ammende si Le temps ou il se park
        // depasse depasse la durrée estimée
        if ($this->dateServe->estPlusPetitQue($parking->getDateFin(),$this->dateServe->getNow()))
        {
            return false;
        }
        return true;
    }
    


}

?>