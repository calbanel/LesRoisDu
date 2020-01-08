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
     * @ORM\Column(type="string", length=20)
     */
    private $couleur;

    /**
     * @ORM\Column(type="integer")
     */
    private $avancementPlateau;

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
}