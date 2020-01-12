<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CasesRepository")
 */
class Cases
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $descriptifDefi;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $consignes;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $codeValidation;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescriptifDefi(): ?string
    {
        return $this->descriptifDefi;
    }

    public function setDescriptifDefi(string $descriptifDefi): self
    {
        $this->descriptifDefi = $descriptifDefi;

        return $this;
    }

    public function getConsignes(): ?string
    {
        return $this->consignes;
    }

    public function setConsignes(?string $consignes): self
    {
        $this->consignes = $consignes;

        return $this;
    }

    public function getCodeValidation(): ?string
    {
        return $this->codeValidation;
    }

    public function setCodeValidation(?string $codeValidation): self
    {
        $this->codeValidation = $codeValidation;

        return $this;
    }
}
