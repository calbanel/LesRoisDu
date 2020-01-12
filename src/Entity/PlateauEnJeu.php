<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlateauEnJeuRepository")
 */
class PlateauEnJeu
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
     * @ORM\OneToOne(targetEntity="App\Entity\Partie", mappedBy="plateauDeJeu", cascade={"persist", "remove"})
     */
    private $partie;

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

    public function getPartie(): ?Partie
    {
        return $this->partie;
    }

    public function setPartie(?Partie $partie): self
    {
        $this->partie = $partie;

        // set (or unset) the owning side of the relation if necessary
        $newPlateauDeJeu = null === $partie ? null : $this;
        if ($partie->getPlateauDeJeu() !== $newPlateauDeJeu) {
            $partie->setPlateauDeJeu($newPlateauDeJeu);
        }

        return $this;
    }
}
