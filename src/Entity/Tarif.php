<?php

namespace App\Entity;

use App\Repository\TarifRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TarifRepository::class)
 */
class Tarif
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="time")
     */
    private $temps;

    /**
     * @ORM\Column(type="integer")
     */
    private $prix;

    /**
     * @ORM\OneToMany(targetEntity=Parking::class, mappedBy="tarif")
     */
    private $parking;

    /**
     * @ORM\OneToMany(targetEntity=Historique::class, mappedBy="tarif")
     */
    private $historiques;

    public function __construct()
    {
        $this->parking = new ArrayCollection();
        $this->historiques = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTemps(): ?\DateTimeInterface
    {
        return $this->temps;
    }

    public function setTemps(\DateTimeInterface $temps): self
    {
        $this->temps = $temps;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->prix;
    }

    public function setPrix(int $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function __toString()
    {
        return $this->getTemps()->format("H:i:s")." - ".$this->getPrix()."Ar";
    }

    /**
     * @return Collection<int, Parking>
     */
    public function getParking(): Collection
    {
        return $this->parking;
    }

    public function addParking(Parking $parking): self
    {
        if (!$this->parking->contains($parking)) {
            $this->parking[] = $parking;
            $parking->setTarif($this);
        }

        return $this;
    }

    public function removeParking(Parking $parking): self
    {
        if ($this->parking->removeElement($parking)) {
            // set the owning side to null (unless already changed)
            if ($parking->getTarif() === $this) {
                $parking->setTarif(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Historique>
     */
    public function getHistoriques(): Collection
    {
        return $this->historiques;
    }

    public function addHistorique(Historique $historique): self
    {
        if (!$this->historiques->contains($historique)) {
            $this->historiques[] = $historique;
            $historique->setTarif($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): self
    {
        if ($this->historiques->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getTarif() === $this) {
                $historique->setTarif(null);
            }
        }

        return $this;
    }

}
