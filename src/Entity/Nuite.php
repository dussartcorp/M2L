<?php

namespace App\Entity;

use App\Repository\NuiteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NuiteRepository::class)
 */
class Nuite
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
    private $dateNuitee;

    /**
     * @ORM\ManyToOne(targetEntity=Hotel::class, inversedBy="nuites")
     */
    private $hotel;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieChambre::class, inversedBy="nuites",name="categorieChambre")
     */
    private $categorieChambre;


    public function __construct()
    {
        
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateNuitee(): ?\DateTimeInterface
    {
        return $this->dateNuitee;
    }

    public function setDateNuitee(\DateTimeInterface $dateNuitee): self
    {
        $this->dateNuitee = $dateNuitee;

        return $this;
    }

    public function getHotel():?Hotel
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


}
