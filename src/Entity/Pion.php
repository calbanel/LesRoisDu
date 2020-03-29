<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PionRepository")
 */
class Pion
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $couleur;

    /**
     * @ORM\Column(type="integer")
     */
    private $avancementPlateau;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\PlateauEnJeu", inversedBy="pions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $plateauEnJeu;

    /**
     * @ORM\Column(type="integer")
     */
    private $numeroJoueur;

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

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getAvancementPlateau(): ?int
    {
        return $this->avancementPlateau;
    }

    public function setAvancementPlateau(int $avancementPlateau): self
    {
        $this->avancementPlateau = $avancementPlateau;

        return $this;
    }

    public function getPlateauEnJeu(): ?PlateauEnJeu
    {
        return $this->plateauEnJeu;
    }

    public function setPlateauEnJeu(?PlateauEnJeu $plateauEnJeu): self
    {
        $this->plateauEnJeu = $plateauEnJeu;

        return $this;
    }

    public function getNumeroJoueur(): ?int
    {
        return $this->numeroJoueur;
    }

    public function setNumeroJoueur(int $numeroJoueur): self
    {
        $this->numeroJoueur = $numeroJoueur;

        return $this;
    }
}
