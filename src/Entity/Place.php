<?php

namespace App\Entity;


use App\Repository\PlaceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PlaceRepository::class)
 */
class Place
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $noPark;

    /**
     * @ORM\OneToOne(targetEntity=Parking::class, mappedBy="place")
     */
    private $parking;

    /**
     * @ORM\OneToOne(targetEntity=EtatPlace::class, mappedBy="place", cascade={"persist", "remove"})
     */
    private $etatPlace;

    /**
     * @ORM\OneToMany(targetEntity=Historique::class, mappedBy="place")
     */
    private $client;

    public function __construct()
    {
        $this->client = new ArrayCollection();
    }

    
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNoPark(): ?string
    {
        return $this->noPark;
    }

    public function setNoPark(string $noPark): self
    {
        $this->noPark = $noPark;

        return $this;
    }
    public function __toString()
    {
        return $this->getNoPark();

    }
   

    public function getParking(): ?Parking
    {
        return $this->parking;
    }

    public function setParking(Parking $parking): self
    {
        // set the owning side of the relation if necessary
        if ($parking->getPlace() !== $this) {
            $parking->setPlace($this);
        }

        $this->parking = $parking;

        return $this;
    }

    public function getEtatPlace(): ?EtatPlace
    {
        return $this->etatPlace;
    }

    public function setEtatPlace(?EtatPlace $etatPlace): self
    {
        // unset the owning side of the relation if necessary
        if ($etatPlace === null && $this->etatPlace !== null) {
            $this->etatPlace->setPlace(null);
        }

        // set the owning side of the relation if necessary
        if ($etatPlace !== null && $etatPlace->getPlace() !== $this) {
            $etatPlace->setPlace($this);
        }

        $this->etatPlace = $etatPlace;

        return $this;
    }

    /**
     * @return Collection<int, Historique>
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Historique $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
            $client->setPlace($this);
        }

        return $this;
    }

    public function removeClient(Historique $client): self
    {
        if ($this->client->removeElement($client)) {
            // set the owning side to null (unless already changed)
            if ($client->getPlace() === $this) {
                $client->setPlace(null);
            }
        }

        return $this;
    }

   
}
