<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Table(name="utilisateur")
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=30, unique=true)
     */
    private $pseudo;

    /**
     * @Assert\NotBlank()
     * @Assert\Length(max=4096)
     */
    private $plainPassword;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $motDePasse;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estInvite;

    /**
     * @ORM\Column(type="text")
     */
    private $avatar;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Partie", mappedBy="joueurs")
     */
    private $partiesRejoins;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partie", mappedBy="createur")
     */
    private $partiesCree;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\PlateauEnJeu", mappedBy="joueur")
     */
    private $plateauEnJeux;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Plateau", mappedBy="utilisateurs")
     */
    private $plateaux;

    public function __construct()
    {
        $this->partiesRejoins = new ArrayCollection();
        $this->partiesCree = new ArrayCollection();
        $this->plateauEnJeux = new ArrayCollection();
        $this->plateaux = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    
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
    public function getPassword()
    {
        return (string) $this->motDePasse;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed for apps that do not check user passwords
        return null;
    }
    
    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(string $pseudo): self
    {
        $this->pseudo = $pseudo;

        return $this;
    }

    public function getPlainPassword()
    {
        return $this->plainPassword;
    }

    public function setPlainPassword($password)
    {
        $this->plainPassword = $password;
    }

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getEstInvite(): ?bool
    {
        return $this->estInvite;
    }

    public function setEstInvite(bool $estInvite): self
    {
        $this->estInvite = $estInvite;

        return $this;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function setAvatar(string $avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection|Partie[]
     */
    public function getPartiesRejoins(): Collection
    {
        return $this->partiesRejoins;
    }

    public function addPartiesRejoin(Partie $partiesRejoin): self
    {
        if (!$this->partiesRejoins->contains($partiesRejoin)) {
            $this->partiesRejoins[] = $partiesRejoin;
            $partiesRejoin->addJoueur($this);
        }

        return $this;
    }

    public function removePartiesRejoin(Partie $partiesRejoin): self
    {
        if ($this->partiesRejoins->contains($partiesRejoin)) {
            $this->partiesRejoins->removeElement($partiesRejoin);
            $partiesRejoin->removeJoueur($this);
        }

        return $this;
    }

    /**
     * @return Collection|Partie[]
     */
    public function getPartiesCree(): Collection
    {
        return $this->partiesCree;
    }

    public function addPartiesCree(Partie $partiesCree): self
    {
        if (!$this->partiesCree->contains($partiesCree)) {
            $this->partiesCree[] = $partiesCree;
            $partiesCree->setCreateur($this);
        }

        return $this;
    }

    public function removePartiesCree(Partie $partiesCree): self
    {
        if ($this->partiesCree->contains($partiesCree)) {
            $this->partiesCree->removeElement($partiesCree);
            // set the owning side to null (unless already changed)
            if ($partiesCree->getCreateur() === $this) {
                $partiesCree->setCreateur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PlateauEnJeu[]
     */
    public function getPlateauEnJeux(): Collection
    {
        return $this->plateauEnJeux;
    }

    public function addPlateauEnJeux(PlateauEnJeu $plateauEnJeux): self
    {
        if (!$this->plateauEnJeux->contains($plateauEnJeux)) {
            $this->plateauEnJeux[] = $plateauEnJeux;
            $plateauEnJeux->setJoueur($this);
        }

        return $this;
    }

    public function removePlateauEnJeux(PlateauEnJeu $plateauEnJeux): self
    {
        if ($this->plateauEnJeux->contains($plateauEnJeux)) {
            $this->plateauEnJeux->removeElement($plateauEnJeux);
            // set the owning side to null (unless already changed)
            if ($plateauEnJeux->getJoueur() === $this) {
                $plateauEnJeux->setJoueur(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Plateau[]
     */
    public function getPlateaux(): Collection
    {
        return $this->plateaux;
    }

    public function addPlateau(Plateau $plateau): self
    {
        if (!$this->plateaux->contains($plateau)) {
            $this->plateaux[] = $plateau;
            $plateau->addUtilisateur($this);
        }

        return $this;
    }

    public function removePlateau(Plateau $plateau): self
    {
        if ($this->plateaux->contains($plateau)) {
            $this->plateaux->removeElement($plateau);
            $plateau->removeUtilisateur($this);
        }

        return $this;
    }
}
