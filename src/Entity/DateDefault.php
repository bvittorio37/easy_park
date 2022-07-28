<?php

namespace App\Entity;

class DateDefault
{
    
    private $id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatenow(): ?\DateTimeInterface
    {
        return $this->datenow;
    }

    public function getPlaceDisponible(\DateTime $dateDefault,$listesDesplaces )
   {
        
        $object=array();
        $retours=array();
       
        
        foreach ($listesDesplaces as $place){
           
           $interv =  $this->getIntervalParPlace($dateDefault, $place);

           $object["idplace"]= $place->getId();
           $object["couleur"] = $interv->getCouleur();
           $object["etat"]=$interv->getEtat();
           $obj= (object)$object;
           array_push($retours, $obj);
        }
       
        return $retours ;
    }
     public function additionnerDateetHeure(\DateTime $date, \DateTime $heure){
       // $heure =date_create(" 1970-01-01 00:30:00");
        //dd($heure);
        $date_string=date_format($date,'Y-m-d H:i:s');
        $h = date_format($heure,"H");
        $s =date_format($heure,"s");
        $m =date_format($heure,"i");
        
        //$daty = date_add($date,date_interval_create_from_date_string($h."hours"." ".$m." min"." ".$s."sec"));
        
        $addition_string = date('Y-m-d H:i:s',strtotime("+$h hours $m minutes $s seconds", strtotime($date_string)));
        $addition = date_create($addition_string);
        
        return $addition;
     }
     public function controleGratuiTe($dateDebut,$dateFin){
        $date_str=date_format($dateFin,'Y-m-d H:i:s');
        $ans = date_format($dateDebut,"Y");
        $mois = date_format($dateDebut,"m");
        $jour = date_format($dateDebut,"d");
        //return  date_create(" "+$ans+"-"+$mois+"-"+$jour+" 08:00:00");
        //Debut
        $format = '%s-%s-%s 18:00:00';
        $gratuitDebut= date_create( sprintf($format, $ans, $mois,$jour));

        //Fin
        $format = '%s-%s-%s 23:59:00';
        $gratuitFin= date_create( sprintf($format, $ans, $mois,$jour))  ;

        //Condition 
        $diff_de= date_diff($gratuitDebut,$dateDebut);
        
        $diff_fi= date_diff($dateDebut,$gratuitFin);
     
        if( $diff_fi->invert==0 && $diff_de->invert==0){
            $foramat_string= date('Y-m-d H:i:s',strtotime("+00 hours 35 minutes 00 seconds", strtotime( $date_str)));
            $dateFin= date_create($foramat_string);
        }
        return $dateFin;
     }
     public function controleGratuiTe2($dateDebut,$dateFin){
        
        $date_str=date_format($dateFin,'Y-m-d H:i:s');
        $ans = date_format($dateDebut,"Y");
        $mois = date_format($dateDebut,"m");
        $jour = date_format($dateDebut,"d");
        //return  date_create(" "+$ans+"-"+$mois+"-"+$jour+" 08:00:00");
        //Debut
        $format = '%s-%s-%s 15:00:00';
        $gratuitDebut= date_create( sprintf($format, $ans, $mois,$jour));

        //Fin
        $format = '%s-%s-%s 16:00:00';
        $gratuitFin= date_create( sprintf($format, $ans, $mois,$jour))  ;

        //Condition 
        $diff_de= date_diff($gratuitDebut,$dateDebut);
        
        $diff_fi= date_diff($dateDebut,$gratuitFin);
     
        if( $diff_fi->invert==0 && $diff_de->invert==0){
            $foramat_string= date('Y-m-d H:i:s',strtotime("+00 hours 35 minutes 00 seconds", strtotime( $date_str)));
            $dateFin= date_create($foramat_string);
        }
        return $dateFin;
     }






    public function getIntervalParPlace(\DateTime $now_default,Place $place) 
    {
        //$retour =null ;
        $interVal = new Interval();
        $interVal->setSigne(-1);
        $interVal->setCouleur("vert");
        $interVal->setEtat("Libre");
    //////////////////////////////////

 //       $now_default= date_create("2022-07-17 08:00:00");

     /////////////////////////:////   
       // dd(date_create(date("H:i:s"))); 
        
        if(!$place->getEtatPlace()){
            if($place->getParking()!== null){

                $heureTarif = $place->getParking()->getTarif()->getTemps();
                
                $date_debut= $place->getParking()->getDebut();

               
                   /*  ---Test--- */
              /*  $no= date_create("2022-07-17 08:00:00");

                $da=date_create("2022-07-17 10:00:01"); 
                 dd(date_diff($no,$da)) ;
                
                $no= date_create("2022-07-17 18:00:00");
                dd($this->controleGratuiTe($no) );
                */
                $diff_debut= date_diff($date_debut,$now_default);
                
                $date_fin= $this->additionnerDateetHeure($date_debut,$heureTarif);
                /// Controle gratuite
                $date_fin=$this->controleGratuiTe($date_debut,$date_fin);
                
                $date_fin=$this->controleGratuiTe2($date_debut,$date_fin);
                //dd($date_fin);
                $diff_fin= date_diff($now_default,$date_fin);
                
      //          dd($diff_debut);

                 if( $diff_fin->invert==1  ){
                    //$interVal->setJour($diff_fin->days);
                    $interVal->setcouleur("red");
                    $interVal->setEtat("Infraction");
                    $interVal->setJour("Depuis".$diff_fin->days);
                    $interVal->setSigne($diff_fin->invert);
                } elseif($diff_debut->invert==1 )
                {
                    $interVal->setSigne(-1);
                    $interVal->setCouleur("vert");
                    $interVal->setEtat("Libre");
                }else{
                    $interVal->setSigne($diff_fin->invert);
                    $interVal->setCouleur("bleu");$interVal->setEtat('Infraction');
                    $interVal->setEtat('Occupé');
                    $restEnString = " ".$diff_fin->h." :".$diff_fin->i." :".$diff_fin->s ;
                    $interVal->setJour( " dans ".$restEnString);
                }
                $interVal->setHeure( $diff_fin->h);
                $interVal->setMin( $diff_fin->i);
                $interVal->setSec( $diff_fin->s);
            } 
            }
        else{
            $interVal->setSigne(2);
            $interVal->setCouleur("gris");
            $interVal->setEtat("Desactive");
            }
 
    
            return $interVal;      

        } 
                    //date_add($datedebut,date_interval_create_from_date_string($h."hours"." ".$m." min"." ".$s."sec"));
}                   //$datedebut= date_format($parking->getDebut(),"H:i:s");
                    
                 
  /*         TaLoha          
                    
                    
                    if($retour->invert==1){
                        //Infraction
                        $interVal->setCouleur("red");
                        $interVal->setEtat('Infraction');
                        $interVal->setJour( " il y a ".$restEnString);
                    }
                    else{
                        //Occupé
                        $interVal->setCouleur("bleu");$interVal->setEtat('Infraction');
                        $interVal->setEtat('Occupé');
                        $interVal->setJour( " dans ".$restEnString);
                        
                    }
                    $interVal->setHeure($retour->h);
                    $interVal->setMin($retour->i);
                    $interVal->setSec($retour->s);
                }
                
            } 
 
    
    return $interVal;      
    }

} */