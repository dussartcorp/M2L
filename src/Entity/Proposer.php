<?php

namespace App\Entity;

use App\Repository\ProposerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProposerRepository::class)
 * @ORM\Table(name="Proposer")
 */
class Proposer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2,name="tarifNuitee")
     */
    private $tarifNuitee;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieChambre::class, inversedBy="tarifs",cascade={"persist"})
     * @ORM\JoinColumn(name="idcategorie")
     */
    private $categorie;

    /**
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="tarifs",cascade={"persist"})
     * @ORM\JoinColumn(name="idhotel")
     */
    private $hotel;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTarifNuitee(): ?string
    {
        return $this->tarifNuitee;
    }

    public function setTarifNuitee(string $tarifNuitee): self
    {
        $this->tarifNuitee = $tarifNuitee;

        return $this;
    }

    public function getCategorie(): ?CategorieChambre
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieChambre $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getHotel(): ?Hotel
    {
        return $this->hotel;
    }

    public function setHotel(?Hotel $hotel): self
    {
        $this->hotel = $hotel;

        return $this;
    }
}
