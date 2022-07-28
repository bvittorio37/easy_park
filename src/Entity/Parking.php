<?php

namespace App\Entity;

use App\Repository\ParkingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParkingRepository::class)
 */
class Parking
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $matricule;

   

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $debut;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $sortie;

    /**
     * @ORM\OneToOne(targetEntity=Place::class, inversedBy="parking")
     * @ORM\JoinColumn(nullable=false)
     */
    private $place;

   

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="parkings")
     */
    private $Client;

    /**
     * @ORM\ManyToOne(targetEntity=Tarif::class, inversedBy="parking")
     */
    private $tarif;

    private $ammende;
    private $dateFin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?string
    {
        return $this->matricule;
    }

    public function setMatricule(string $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }



    public function getDebut(): ?\DateTime
    {
        return $this->debut;
    }

    public function setDebut(\DateTime $debut): self
    {
        $this->debut = $debut;

        return $this;
    }

    public function getSortie(): ?\DateTimeInterface
    {
        return $this->sortie;
    }

    public function setSortie(?\DateTimeInterface $sortie): self
    {
        $this->sortie = $sortie;

        return $this;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getClient(): ?Utilisateur
    {
        return $this->Client;
    }

    public function setClient(?Utilisateur $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    public function getTarif(): ?Tarif
    {
        return $this->tarif;
    }

    public function setTarif(?Tarif $tarif): self
    {
        $this->tarif = $tarif;

        return $this;
    }
    public function setDateFin(\DateTime $dateFin){
        $this->dateFin= $dateFin;
    }
    public function getDateFin(): \DateTimeInterface
    {
        if (!$this->dateFin){
            $dateDefault= new DateDefault;
            $heureTarif = $this->getTarif()->getTemps();     
            $date_debut= $this->getDebut();
            $date_fin= $dateDefault->additionnerDateetHeure($date_debut,$heureTarif);
            return $date_fin;
        }
       return $this->dateFin;
       
    }
    public function setAmmende($ammende){
        $this->ammende = $ammende;
    }
    public function getAmmende(){
        return $this->ammende;
    }

   

  
}
