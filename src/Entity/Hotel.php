<?php

namespace App\Entity;

use App\Repository\HotelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HotelRepository::class)
 * @ORM\Table(name="Hotel")
 */
class Hotel
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100,name="nomHotel")
     */
    private $nomHotel;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $adresse1;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $adresse2;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $cp;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $ville;

    /**
     * @ORM\Column(type="string")
     */
    private $tel;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $mail;

    /**
     * @ORM\OneToMany(targetEntity=Nuitee::class, mappedBy="hotel")
     */
    private $Nuitees;

    /**
     * @ORM\OneToMany(targetEntity=Proposer::class, mappedBy="hotel")
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

    public function getNomHotel(): ?string
    {
        return $this->nomHotel;
    }

    public function setNomHotel(string $nomHotel): self
    {
        $this->nomHotel = $nomHotel;

        return $this;
    }

    public function getAdresse1(): ?string
    {
        return $this->adresse1;
    }

    public function setAdresse1(string $adresse1): self
    {
        $this->adresse1 = $adresse1;

        return $this;
    }

    public function getAdresse2(): ?string
    {
        return $this->adresse2;
    }

    public function setAdresse2(?string $adresse2): self
    {
        $this->adresse2 = $adresse2;

        return $this;
    }

    public function getCp(): ?string
    {
        return $this->cp;
    }

    public function setCp(string $cp): self
    {
        $this->cp = $cp;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

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
            $Nuitee->setHotel($this);
        }

        return $this;
    }

    public function removeNuitee(Nuitee $Nuitee): self
    {
        if ($this->Nuitees->removeElement($Nuitee)) {
            // set the owning side to null (unless already changed)
            if ($Nuitee->getHotel() === $this) {
                $Nuitee->setHotel(null);
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
            $tarif->setHotel($this);
        }

        return $this;
    }

    public function removeTarif(Proposer $tarif): self
    {
        if ($this->tarifs->removeElement($tarif)) {
            // set the owning side to null (unless already changed)
            if ($tarif->getHotel() === $this) {
                $tarif->setHotel(null);
            }
        }

        return $this;
    }


}
