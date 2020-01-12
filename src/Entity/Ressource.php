<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RessourceRepository")
 */
class Ressource
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $chemin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cases", inversedBy="ressources")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cases;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChemin(): ?string
    {
        return $this->chemin;
    }

    public function setChemin(string $chemin): self
    {
        $this->chemin = $chemin;

        return $this;
    }

    public function getCases(): ?Cases
    {
        return $this->cases;
    }

    public function setCases(?Cases $cases): self
    {
        $this->cases = $cases;

        return $this;
    }
}
