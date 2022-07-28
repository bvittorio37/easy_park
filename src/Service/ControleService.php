<?php
nameSpace App\Service;

Class ControleService
{
    public function __construct()
    {
       
    }
    public function isDateCompris(String $heure_deb, String $heure_fin , \DateTime $dateAgerer):bool
    {
        $retour=false;
        
        $ans = date_format($dateAgerer,"Y");
        $mois = date_format($dateAgerer,"m");
        $jour = date_format($dateAgerer,"d");
        //return  date_create(" "+$ans+"-"+$mois+"-"+$jour+" 08:00:00");
        //Debut
        $format = '%s-%s-%s '.$heure_deb ;
        $gratuitDebut= date_create( sprintf($format, $ans, $mois,$jour))  ;

        //Fin
        $format = '%s-%s-%s '.$heure_fin;
        $gratuitFin= date_create( sprintf($format, $ans, $mois,$jour))  ;

        //Condition 
        $diff_de= date_diff($gratuitDebut,$dateAgerer);
        
        $diff_fi= date_diff($dateAgerer,$gratuitFin);
     
        if( $diff_fi->invert==0 && $diff_de->invert==0){
            $retour=true;
        }
       
        return $retour; 
    }

    public function isGratuit($dateDebut){
       if($this->isDateCompris('18:00:00','23:59:00',$dateDebut))
       {
        $date_str=date_format($dateDebut,'Y-m-d H:i:s');
        $foramat_string= date('Y-m-d H:i:s',strtotime("+00 hours 35 minutes 00 seconds", strtotime( $date_str)));
        $dateDebut= date_create($foramat_string);
       }
       return $dateDebut;
    }
    public function isGratuitTo($dateDebut){
        if($this->isDateCompris('16:00:00','35:00:00',$dateDebut))
        {
         $date_str=date_format($dateDebut,'Y-m-d H:i:s');
         $foramat_string= date('Y-m-d H:i:s',strtotime("+00 hours 35 minutes 00 seconds", strtotime( $date_str)));
         $dateDebut= date_create($foramat_string);
        }
        return $dateDebut;
     }





    public function estGratuit($dateDebut){
        $retour=date_create("00:00:00");
        if($this->isDateCompris('18:00:00','23:59:00',$dateDebut))
        {
         $date_str=date_format($dateDebut,'Y-m-d H:i:s');
         $foramat_string= date('Y-m-d H:i:s',strtotime("+00 hours 35 minutes 00 seconds", strtotime( $date_str)));
         $dateDebut= date_create("00:35:00");
         $retour=$dateDebut= date_create("00:35:00");
        
        }
        return $retour;
     }
     public function estGratuit2($dateDebut){
        $retour=date_create("00:00:00");
        if($this->isDateCompris('15:00:00','16:00:00',$dateDebut))
        {
         $date_str=date_format($dateDebut,'Y-m-d H:i:s');
         $foramat_string= date('Y-m-d H:i:s',strtotime("+00 hours 35 minutes 00 seconds", strtotime( $date_str)));
         $dateDebut= date_create("00:35:00");
         $retour=$dateDebut= date_create("00:35:00");
        
        }
        return $retour ;
     }


    public function isRemise($dateDebut,$prix){
        if($this->isDateCompris('06:00:00','08:00:00',$dateDebut))
        {
            $prix= (int)($prix*(1-0.15));
        }
        return $prix;
     }
     public function estRemise($dateDebut,$prix){
        $retour=0;
        if($this->isDateCompris('06:00:00','08:00:00',$dateDebut))
        {
            $retour= (int)($prix*(1-0.15));
        }
        return 15;
     }

     public function isDeduction($dateDebut,$prix,$solde){
        if($this->isDateCompris('12:00:00','14:00:00',$dateDebut))
        {
            $prix=(int)($prix*(1+0.10));
        }
       return $prix;
     }

     public function estDeduction($dateDebut,$prix){
        $retour=0;
        if($this->isDateCompris('12:00:00','14:00:00',$dateDebut))
        {
            //
            //dd($dateDebut);
           // $retour=
        }
       return 10;
     }



    



}

?>