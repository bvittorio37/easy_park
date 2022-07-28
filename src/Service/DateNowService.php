<?php
nameSpace App\Service;

use App\Repository\DatenowRepository;

Class DateNowService
{
    private $nowRipo;
    public function __construct(DatenowRepository $nowRipo )
    {
      $this->nowRipo = $nowRipo;
    }
   
    public function getNow()

    {
        if(!$this->nowRipo->getDefaultValue()){
            $getnow=date_create(date("H:i:s"));
        }
        else{
            $getnow=$this->nowRipo->getDefaultValue()[0]->getDatenow();
        }
        
        return $getnow;
    }
    public function estPlusPetitQue(\DateTime $lepetit, \DateTime $legrand)
    {
        if( date_diff($lepetit,$legrand)->invert==0){
            return true;
        }
        return false;
    }
}

?>