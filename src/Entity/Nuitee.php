<?php

namespace App\Entity;

use App\Repository\NuiteeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NuiteeRepository::class)
 * @ORM\Table(name="Nuitee")
 */
class Nuitee
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime",name="dateNuitee")
     */
    private $dateNuiteee;

    /**
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="Nuitees",cascade={"persist"})
     * @ORM\JoinColumn(name="idhotel")
     */
    private $hotel;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieChambre::class, inversedBy="Nuitees",cascade={"persist"})
     * @ORM\JoinColumn(name="idcategorieChambre")
     */
    private $categorieChambre;

    /**
     * @ORM\ManyToOne(targetEntity=Inscription::class, inversedBy="nuitees")
     * @ORM\JoinColumn(nullable=false, name="idinscription")
     */
    private $inscriptions;


    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateNuiteee(): ?\DateTimeInterface
    {
        return $this->dateNuiteee;
    }

    public function setDateNuiteee(\DateTimeInterface $dateNuiteee): self
    {
        $this->dateNuiteee = $dateNuiteee;

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

    public function getCategorieChambre(): ?CategorieChambre
    {
        return $this->categorieChambre;
    }

    public function setCategorieChambre(?CategorieChambre $categorieChambre): self
    {
        $this->categorieChambre = $categorieChambre;

        return $this;
    }

    public function getInscriptions(): ?Inscription
    {
        return $this->inscriptions;
    }

    public function setInscriptions(?Inscription $inscriptions): self
    {
        $this->inscriptions = $inscriptions;

        return $this;
    }
}
