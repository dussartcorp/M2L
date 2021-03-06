<?php

namespace App\Entity;

use App\Repository\AtelierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AtelierRepository::class)
 * @ORM\Table(name="Atelier")
 */
class Atelier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $libelle;

    /**
     * @ORM\Column(type="integer",name="nbPlaceMaxi")
     */
    private $nbPlaceMaxi;

    /**
     * @ORM\ManyToMany(targetEntity=Inscription::class, mappedBy="ateliers")
     */
    private $inscriptions;

    /**
     * @ORM\ManyToMany(targetEntity=Theme::class, inversedBy="ateliers",cascade={"persist"})
     * @ORM\JoinTable(
     *        name="Themesparatelier",
     *        joinColumns={@ORM\JoinColumn(name="idatelier", referencedColumnName="id")},
     *        inverseJoinColumns={@ORM\JoinColumn(name="idtheme", referencedColumnName="id")}
     *        )
     */
    private $themes;

    /**
     * @ORM\ManyToOne(targetEntity=Vacation::class)
     * @ORM\JoinColumn(name="idvacation")
     */
    private $vacations;


    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
        $this->themes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->libelle;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getNbPlaceMaxi(): ?int
    {
        return $this->nbPlaceMaxi;
    }

    public function setNbPlaceMaxi(int $nbPlaceMaxi): self
    {
        $this->nbPlaceMaxi = $nbPlaceMaxi;

        return $this;
    }

    /**
     * @return Collection|Inscription[]
     */
    public function getInscriptions(): Collection
    {
        return $this->inscriptions;
    }

    public function addInscription(Inscription $inscription): self
    {
        if (!$this->inscriptions->contains($inscription)) {
            $this->inscriptions[] = $inscription;
            $inscription->addAtelier($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            $inscription->removeAtelier($this);
        }

        return $this;
    }

    /**
     * @return Collection|Theme[]
     */
    public function getThemes(): Collection
    {
        return $this->themes;
    }

    public function addTheme(Theme $theme): self
    {
        if (!$this->themes->contains($theme)) {
            $this->themes[] = $theme;
        }

        return $this;
    }

    public function removeTheme(Theme $theme): self
    {
        $this->themes->removeElement($theme);

        return $this;
    }

    public function getVacations(): ?Vacation
    {
        return $this->vacations;
    }

    public function setVacations(?Vacation $vacations): self
    {
        $this->vacations = $vacations;

        return $this;
    }

   
}
