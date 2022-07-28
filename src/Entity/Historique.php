<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HistoriqueRepository::class)
 */
class Historique
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Place::class, inversedBy="client")
     * @ORM\JoinColumn(nullable=false)
     */
    private $place;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="historiques")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $matricule;

    /**
     * @ORM\Column(type="datetime")
     */
    private $debut;

    /**
     * @ORM\ManyToOne(targetEntity=Tarif::class, inversedBy="historiques")
     */
    private $tarif;

    /**
     * @ORM\Column(type="datetime")
     */
    private $depart;
    private $ammende;

 


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPlace(): ?Place
    {
        return $this->place;
    }

    public function setPlace(?Place $place): self
    {
        $this->place = $place;

        return $this;
    }

    public function getClient(): ?Utilisateur
    {
        return $this->client;
    }

    public function setClient(?Utilisateur $client): self
    {
        $this->client = $client;

        return $this;
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

    public function getDebut(): ?\DateTimeInterface
    {
        return $this->debut;
    }

    public function setDebut(\DateTimeInterface $debut): self
    {
        $this->debut = $debut;

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

    public function getDepart(): ?\DateTimeInterface
    {
        return $this->depart;
    }

    public function setDepart(\DateTimeInterface $depart): self
    {
        $this->depart = $depart;

        return $this;
    }
    public function getDateFin(): \DateTimeInterface
    {
        $dateDefault= new DateDefault;
        $heureTarif = $this->getTarif()->getTemps();     
        $date_debut= $this->getDebut();
        $date_fin= $dateDefault->additionnerDateetHeure($date_debut,$heureTarif);
        return $date_fin;
    }
   

   
  

    /**
     * Get the value of ammende
     */ 
    public function getAmmende()
    {
        return $this->ammende;
    }

    /**
     * Set the value of ammende
     *
     * @return  self
     */ 
    public function setAmmende($ammende)
    {
        $this->ammende = $ammende;

        return $this;
    }
}
