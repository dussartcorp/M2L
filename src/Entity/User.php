<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Regex;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=9, unique=true)
     * @Assert\Length(
     *              min=9, 
     *              max=9,
     *              minMessage="Le numéro de licence doit contenir 9 chiffres",
     *              maxMessage="Le numéro de licence doit contenir 9 chiffres")
     */
    private $numLicence;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;


    /**
     * @ORM\OneToOne(targetEntity=Inscription::class, mappedBy="compte", cascade={"persist", "remove"})
     */
    private $inscription;

    /**
     * @ORM\OneToOne(targetEntity=Licencie::class, mappedBy="compte", cascade={"persist", "remove"})
     */
    private $licencie;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *              message="L'adresse mail n'est pas valide")
     */
    private $Email;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumLicence(): ?string
    {
        return $this->numLicence;
    }

    public function setNumLicence(string $numLicence): self
    {
        $this->numLicence = $numLicence;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->numLicence;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    
    public function getInscription(): ?Inscription
    {
        return $this->inscription;
    }

    public function setInscription(?Inscription $inscription): self
    {
        $this->inscription = $inscription;

        // set (or unset) the owning side of the relation if necessary
        $newCompte = null === $inscription ? null : $this;
        if ($inscription->getCompte() !== $newCompte) {
            $inscription->setCompte($newCompte);
        }

        return $this;
    }

    public function getLicencie(): ?Licencie
    {
        return $this->licencie;
    }

    public function setLicencie(?Licencie $licencie): self
    {
        $this->licencie = $licencie;

        // set (or unset) the owning side of the relation if necessary
        $newCompte = null === $licencie ? null : $this;
        if ($licencie->getCompte() !== $newCompte) {
            $licencie->setCompte($newCompte);
        }

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }
}
