<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 */
class Utilisateur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $pseudo;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $motDePasse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresseMail;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $prenom;

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

    public function __construct()
    {
        $this->partiesRejoins = new ArrayCollection();
        $this->partiesCree = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getMotDePasse(): ?string
    {
        return $this->motDePasse;
    }

    public function setMotDePasse(string $motDePasse): self
    {
        $this->motDePasse = $motDePasse;

        return $this;
    }

    public function getAdresseMail(): ?string
    {
        return $this->adresseMail;
    }

    public function setAdresseMail(string $adresseMail): self
    {
        $this->adresseMail = $adresseMail;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(?string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(?string $prenom): self
    {
        $this->prenom = $prenom;

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
}
