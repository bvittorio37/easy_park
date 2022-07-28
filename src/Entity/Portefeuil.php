<?php

namespace App\Entity;

use App\Repository\PortefeuilRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PortefeuilRepository::class)
 */
class Portefeuil
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity=Utilisateur::class, inversedBy="portefeuil", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $Client;

    /**
     * @ORM\Column(type="integer")
     */
    private $solde;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Utilisateur
    {
        return $this->Client;
    }

    public function setClient(Utilisateur $Client): self
    {
        $this->Client = $Client;

        return $this;
    }

    public function getSolde(): ?int
    {
        return $this->solde;
    }

    public function setSolde(int $solde): self
    {
        $this->solde = $solde;

        return $this;
    }
    
    public function sousTractionService( Utilisateur $client, int $solde , int $prixTarif) :void
    {
        $soldeNouv = $solde-$prixTarif;
      
        $this->id=$client->getPortefeuil()->getId();
        $this->setClient($client);
        $this->setSolde($soldeNouv);
    }
}
