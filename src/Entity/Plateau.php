<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="plateau")
 * @ORM\Entity(repositoryClass="App\Repository\PlateauRepository")
 */
class Plateau
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $niveauDifficulte;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Partie", mappedBy="plateau")
     */
    private $parties;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Cases", mappedBy="plateau", orphanRemoval=true)
     */
    private $cases;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Utilisateur", inversedBy="plateaux")
     */
    private $utilisateurs;

    /**
     * @ORM\Column(type="integer")
     */
    private $nbCases;

    public function __construct()
    {
        $this->parties = new ArrayCollection();
        $this->cases = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getNiveauDifficulte(): ?string
    {
        return $this->niveauDifficulte;
    }

    public function setNiveauDifficulte(string $niveauDifficulte): self
    {
        $this->niveauDifficulte = $niveauDifficulte;

        return $this;
    }

    /**
     * @return Collection|Partie[]
     */
    public function getParties(): Collection
    {
        return $this->parties;
    }

    public function addParty(Partie $party): self
    {
        if (!$this->parties->contains($party)) {
            $this->parties[] = $party;
            $party->setPlateau($this);
        }

        return $this;
    }

    public function removeParty(Partie $party): self
    {
        if ($this->parties->contains($party)) {
            $this->parties->removeElement($party);
            // set the owning side to null (unless already changed)
            if ($party->getPlateau() === $this) {
                $party->setPlateau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cases[]
     */
    public function getCases(): Collection
    {
        return $this->cases;
    }

    public function addCase(Cases $case): self
    {
        if (!$this->cases->contains($case)) {
            $this->cases[] = $case;
            $case->setPlateau($this);
        }

        return $this;
    }

    public function removeCase(Cases $case): self
    {
        if ($this->cases->contains($case)) {
            $this->cases->removeElement($case);
            // set the owning side to null (unless already changed)
            if ($case->getPlateau() === $this) {
                $case->setPlateau(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): self
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs[] = $utilisateur;
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): self
    {
        if ($this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->removeElement($utilisateur);
        }

        return $this;
    }

    public function getNbCases(): ?int
    {
        return $this->nbCases;
    }

    public function setNbCases(int $nbCases): self
    {
        $this->nbCases = $nbCases;

        return $this;
    }
}
