<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UtilisateurRepository::class)
 */
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;
    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];
    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;
    /**
     * @ORM\Column(type="string", length=150)
     */
    private $name;

    /**
     * @ORM\OneToOne(targetEntity=Portefeuil::class, mappedBy="Client", cascade={"persist", "remove"})
     */
    private $portefeuil;

    /**
     * @ORM\OneToMany(targetEntity=Demande::class, mappedBy="Client", orphanRemoval=true)
     */
    private $demandes;

    /**
     * @ORM\OneToMany(targetEntity=Parking::class, mappedBy="Client")
     */
    private $parkings;

    /**
     * @ORM\OneToMany(targetEntity=Historique::class, mappedBy="client")
     */
    private $historiques;

    public function __construct()
    {
        $this->demandes = new ArrayCollection();
        $this->parkings = new ArrayCollection();
        $this->historiques = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getEmail(): ?string
    {
        return $this->email;
    }
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }
    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }
    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }
    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getPortefeuil(): ?Portefeuil
    {
        return $this->portefeuil;
    }

    public function setPortefeuil(Portefeuil $portefeuil): self
    {
        // set the owning side of the relation if necessary
        if ($portefeuil->getClient() !== $this) {
            $portefeuil->setClient($this);
        }

        $this->portefeuil = $portefeuil;

        return $this;
    }

    /**
     * @return Collection<int, Demande>
     */
    public function getDemandes(): Collection
    {
        return $this->demandes;
    }

    public function addDemande(Demande $demande): self
    {
        if (!$this->demandes->contains($demande)) {
            $this->demandes[] = $demande;
            $demande->setClient($this);
        }

        return $this;
    }

    public function removeDemande(Demande $demande): self
    {
        if ($this->demandes->removeElement($demande)) {
            // set the owning side to null (unless already changed)
            if ($demande->getClient() === $this) {
                $demande->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Parking>
     */
    public function getParkings(): Collection
    {
        return $this->parkings;
    }

    public function addParking(Parking $parking): self
    {
        if (!$this->parkings->contains($parking)) {
            $this->parkings[] = $parking;
            $parking->setClient($this);
        }

        return $this;
    }

    public function removeParking(Parking $parking): self
    {
        if ($this->parkings->removeElement($parking)) {
            // set the owning side to null (unless already changed)
            if ($parking->getClient() === $this) {
                $parking->setClient(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getName();
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
            $historique->setClient($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): self
    {
        if ($this->historiques->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getClient() === $this) {
                $historique->setClient(null);
            }
        }

        return $this;
    }

    
}
