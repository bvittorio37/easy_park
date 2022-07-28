<?php

namespace App\Entity;

use App\Repository\EtatPlaceRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EtatPlaceRepository::class)
 */
class EtatPlace
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Place::class, inversedBy="etatPlace", cascade={"persist", "remove"})
     */
    private $place;

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
    
}
