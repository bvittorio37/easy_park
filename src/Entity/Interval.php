<?php

namespace App\Entity;


class Interval
{
   
 
    private $etat;
    private $signe;
    private $jour;
    private $heure;
    private $couleur;
    private $min;
    private $sec;
        

    function __construct() {
        
    }
   

    /**
     * Get the value of signe
     */ 
    public function getSigne()
    {
        return $this->signe;
    }

    /**
     * Set the value of signe
     *
     * @return  self
     */ 
    public function setSigne($signe)
    {
        $this->signe = $signe;

        return $this;
    }

    /**
     * Get the value of heure
     */ 
    public function getHeure()
    {
        return $this->heure;
    }

    /**
     * Set the value of heure
     *
     * @return  self
     */ 
    public function setHeure($heure)
    {
        $this->heure = $heure;

        return $this;
    }

    /**
     * Get the value of min
     */ 
    public function getmin()
    {
        return $this->min;
    }

    /**
     * Set the value of min
     *
     * @return  self
     */ 
    public function setmin($min)
    {
        $this->min = $min;

        return $this;
    }

    /**
     * Get the value of sec
     */ 
    public function getSec()
    {
        return $this->sec;
    }

    /**
     * Set the value of sec
     *
     * @return  self
     */ 
    public function setSec($sec)
    {
        $this->sec = $sec;

        return $this;
    }

    /**
     * Get the value of jour
     */ 
    public function getJour()
    {
        return $this->jour;
    }

    /**
     * Set the value of jour
     *
     * @return  self
     */ 
    public function setJour($jour)
    {
        $this->jour = $jour;

        return $this;
    }

    /**
     * Get the value of couleur
     */ 
    public function getCouleur()
    {
        return $this->couleur;
    }

    /**
     * Set the value of couleur
     *
     * @return  self
     */ 
    public function setCouleur($couleur)
    {
        $this->couleur = $couleur;

        return $this;
    }

    /**
     * Get the value of etat
     */ 
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set the value of etat
     *
     * @return  self
     */ 
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }
}
