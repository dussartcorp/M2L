<?php

namespace App\Entity;

use App\Repository\CategorieChambreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieChambreRepository::class)
 * @ORM\Table(name="Categoriechambre")
 */
class CategorieChambre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50,name="libelleCategorie")
     */
    private $libelleCategorie;

    /**
     * @ORM\OneToMany(targetEntity=Nuitee::class, mappedBy="categorieChambre",cascade={"persist"})
     */
    private $Nuitees;

    /**
     * @ORM\OneToMany(targetEntity=Proposer::class, mappedBy="categorie")
     */
    private $tarifs;

    public function __construct()
    {
        $this->Nuitees = new ArrayCollection();
        $this->tarifs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleCategorie(): ?string
    {
        return $this->libelleCategorie;
    }

    public function setLibelleCategorie(string $libelleCategorie): self
    {
        $this->libelleCategorie = $libelleCategorie;

        return $this;
    }

    /**
     * @return Collection|Nuitee[]
     */
    public function getNuitees(): Collection
    {
        return $this->Nuitees;
    }

    public function addNuitee(Nuitee $Nuitee): self
    {
        if (!$this->Nuitees->contains($Nuitee)) {
            $this->Nuitees[] = $Nuitee;
            $Nuitee->setCategorieChambre($this);
        }

        return $this;
    }

    public function removeNuitee(Nuitee $Nuitee): self
    {
        if ($this->Nuitees->removeElement($Nuitee)) {
            // set the owning side to null (unless already changed)
            if ($Nuitee->getCategorieChambre() === $this) {
                $Nuitee->setCategorieChambre(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Proposer[]
     */
    public function getTarifs(): Collection
    {
        return $this->tarifs;
    }

    public function addTarif(Proposer $tarif): self
    {
        if (!$this->tarifs->contains($tarif)) {
            $this->tarifs[] = $tarif;
            $tarif->setCategorie($this);
        }

        return $this;
    }

    public function removeTarif(Proposer $tarif): self
    {
        if ($this->tarifs->removeElement($tarif)) {
            // set the owning side to null (unless already changed)
            if ($tarif->getCategorie() === $this) {
                $tarif->setCategorie(null);
            }
        }

        return $this;
    }
}
