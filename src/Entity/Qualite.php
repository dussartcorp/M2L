<?php

namespace App\Entity;

use App\Repository\QualiteRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=QualiteRepository::class)
 * @ORM\Table(name="Qualite")
 */
class Qualite
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, name="libellequalite")
     */
    private $libelleQualite;

    public function __toString()
    {
        return $this->libelleQualite;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelleQualite(): ?string
    {
        return $this->libelleQualite;
    }

    public function setLibelleQualite(string $libelleQualite): self
    {
        $this->libelleQualite = $libelleQualite;

        return $this;
    }
}
