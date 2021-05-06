<?php

namespace App\Entity;

use App\Repository\RestaurationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RestaurationRepository::class)
 * @ORM\Table(name="Restauration")
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
     * @ORM\Column(type="string", columnDefinition="enum('Midi', 'Soir')", length=15,name="typesRepas")
     */
    private $typesRepas;

    /**
     * @ORM\ManyToMany(targetEntity=Inscription::class, mappedBy="restaurations")
     */
    private $inscriptions;

    /**
     * @ORM\Column(type="datetime",name="dateRestauration")
     */
    private $dateRestauration;

    public function __construct()
    {
        $this->inscriptions = new ArrayCollection();
    }

    public function __toString()
    {
        return 'Le ' . $this->getDateRestauration()->format('d-m-y'). ' : '. $this->getTypesRepas();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $inscription->addRestauration($this);
        }

        return $this;
    }

    public function removeInscription(Inscription $inscription): self
    {
        if ($this->inscriptions->removeElement($inscription)) {
            $inscription->removeRestauration($this);
        }

        return $this;
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
}
