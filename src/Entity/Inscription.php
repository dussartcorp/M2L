<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 */
class Inscription
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateInscription;

    /**
     * @ORM\ManyToMany(targetEntity=Atelier::class, inversedBy="inscriptions")
     */
    private $ateliers;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="inscription", cascade={"persist", "remove"})
     */
    private $compte;

    /**
     * @ORM\ManyToOne(targetEntity=Restauration::class)
     */
    private $restaurations;

    /**
     * @ORM\ManyToOne(targetEntity=Nuite::class)
     */
    private $nuites;

    public function __construct()
    {
        $this->ateliers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateInscription(): ?\DateTimeInterface
    {
        return $this->dateInscription;
    }

    public function setDateInscription(\DateTimeInterface $dateInscription): self
    {
        $this->dateInscription = $dateInscription;

        return $this;
    }

    /**
     * @return Collection|Atelier[]
     */
    public function getAteliers(): Collection
    {
        return $this->ateliers;
    }

    public function addAtelier(Atelier $atelier): self
    {
        if (!$this->ateliers->contains($atelier)) {
            $this->ateliers[] = $atelier;
        }

        return $this;
    }

    public function removeAtelier(Atelier $atelier): self
    {
        $this->ateliers->removeElement($atelier);

        return $this;
    }

    public function getCompte(): ?User
    {
        return $this->compte;
    }

    public function setCompte(?User $compte): self
    {
        $this->compte = $compte;

        return $this;
    }

    public function getRestaurations(): ?Restauration
    {
        return $this->restaurations;
    }

    public function setRestaurations(?Restauration $restaurations): self
    {
        $this->restaurations = $restaurations;

        return $this;
    }

    public function getNuites(): ?Nuite
    {
        return $this->nuites;
    }

    public function setNuites(?Nuite $nuites): self
    {
        $this->nuites = $nuites;

        return $this;
    }
}
