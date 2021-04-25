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
     * @ORM\Column(type="datetime",name="dateInscription")
     */
    private $dateInscription;

    /**
     * @ORM\ManyToMany(targetEntity=Atelier::class, inversedBy="inscriptions",cascade={"persist"})
     * @ORM\JoinTable(
     *        name="inscriptionparAtelier",
     *        joinColumns={@ORM\JoinColumn(name="idinscription", referencedColumnName="id")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="idatelier", referencedColumnName="id")}
     *        )
     */
    private $ateliers;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="inscription", cascade={"persist", "remove"})
     * @ORM\JoinColumn(name="idcompte")
     */
    private $compte;


    /**
     * @ORM\ManyToMany(targetEntity=Restauration::class, inversedBy="inscriptions",cascade={"persist"})
     * @ORM\JoinTable(
     *        name="inscriptionparRestauration",
     *        joinColumns={@ORM\JoinColumn(name="idinscription", referencedColumnName="id")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="idrestauration", referencedColumnName="id")}
     *        )
     */
    private $restaurations;

    /**
     * @ORM\OneToMany(targetEntity=Nuitee::class, mappedBy="inscriptions", orphanRemoval=true)
     */
    private $nuitees;

    public function __construct()
    {
        $this->ateliers = new ArrayCollection();
        $this->restaurations = new ArrayCollection();
        $this->Nuiteees = new ArrayCollection();
        $this->nuitees = new ArrayCollection();
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

    /**
     * @return Collection|Restauration[]
     */
    public function getRestaurations(): Collection
    {
        return $this->restaurations;
    }

    public function addRestauration(Restauration $restauration): self
    {
        if (!$this->restaurations->contains($restauration)) {
            $this->restaurations[] = $restauration;
            $restauration->setInscriptions($this);
        }

        return $this;
    }

    public function removeRestauration(Restauration $restauration): self
    {
        if ($this->restaurations->removeElement($restauration)) {
            // set the owning side to null (unless already changed)
            if ($restauration->getInscriptions() === $this) {
                $restauration->setInscriptions(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Nuitee[]
     */
    public function getNuitees(): Collection
    {
        return $this->nuitees;
    }

    public function addNuitee(Nuitee $nuitee): self
    {
        if (!$this->nuitees->contains($nuitee)) {
            $this->nuitees[] = $nuitee;
            $nuitee->setInscriptions($this);
        }

        return $this;
    }

    public function removeNuitee(Nuitee $nuitee): self
    {
        if ($this->nuitees->removeElement($nuitee)) {
            // set the owning side to null (unless already changed)
            if ($nuitee->getInscriptions() === $this) {
                $nuitee->setInscriptions(null);
            }
        }

        return $this;
    }

}
