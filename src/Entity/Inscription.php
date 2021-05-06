<?php

namespace App\Entity;

use App\Repository\InscriptionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Count;

/**
 * @ORM\Entity(repositoryClass=InscriptionRepository::class)
 * @ORM\Table(name="Inscription")
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
     *        name="InscriptionparAtelier",
     *        joinColumns={@ORM\JoinColumn(name="idinscription", referencedColumnName="id")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="idatelier", referencedColumnName="id")}
     *        )
     * @Assert\Count(
     *      min = 1,
     *      max = 5,
     *      minMessage = "Veuillez selectionner au moins 1 atelier",
     *      maxMessage = "Vous ne pouvez selectionner que seulement 5 ateliers"
     * )
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
     *        name="InscriptionparRestauration",
     *        joinColumns={@ORM\JoinColumn(name="idinscription", referencedColumnName="id")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="idrestauration", referencedColumnName="id")}
     *        )
     */
    private $restaurations;

    /**
     * @ORM\OneToMany(targetEntity=Nuitee::class, mappedBy="inscriptions", orphanRemoval=true,cascade={"persist"})
     */
    private $nuitees;

    public function __construct()
    {
        $this->ateliers = new ArrayCollection();
        $this->restaurations = new ArrayCollection();
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
        }

        return $this;
    }

    public function removeRestauration(Restauration $restauration): self
    {
        $this->restaurations->removeElement($restauration);

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
