<?php

namespace App\Entity;

use App\Repository\RestaurationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestaurationRepository::class)
 */
class Restauration
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime",name="dateRestauration")
     */
    private $dateRestauration;

    /**
     * @ORM\Column(type="string", length=15,name="typesRepas")
     */
    private $typesRepas;

    /**
     * @ORM\ManyToMany(targetEntity=Inscription::class, inversedBy="restaurations")
     * @ORM\JoinColumn(name="idinscription")
     */
    private $inscriptions;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateRestauration(): ?\DateTimeInterface
    {
        return $this->dateRestauration;
    }

    public function setDateRestauration(\DateTimeInterface $dateRestauration): self
    {
        $this->dateRestauration = $dateRestauration;

        return $this;
    }

    public function getTypesRepas(): ?string
    {
        return $this->typesRepas;
    }

    public function setTypesRepas(string $typesRepas): self
    {
        $this->typesRepas = $typesRepas;

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
