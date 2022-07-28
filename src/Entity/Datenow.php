<?php

namespace App\Entity;

use App\Repository\DatenowRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DatenowRepository::class)
 */
class Datenow
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datenow;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatenow(): ?\DateTimeInterface
    {
        return $this->datenow;
    }

    public function setDatenow(\DateTimeInterface $datenow): self
    {
        $this->datenow = $datenow;

        return $this;
    }
}
