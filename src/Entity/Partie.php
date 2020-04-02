<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PartieRepository")
 */
class Partie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @Assert\NotBlank(message= "Le nom doit être renseigné")
     * @Assert\Length(
     *      min = 4,
     *      max = 40,
     *      minMessage = "Le nom doit au minimum faire {{ limit }} caractères de long",
     *      maxMessage = "Le nom doit au maximum faire {{ limit }} caractères de long",
     * )
     */
    private $nom;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Assert\Length(
     *      min = 4,
     *      max = 350,
     *      minMessage = "La description doit au minimum faire {{ limit }} caractères de long",
     *      maxMessage = "La description doit au maximum faire {{ limit }} caractères de long",
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $code;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Plateau", inversedBy="parties")
     */
    private $plateau;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\PlateauEnJeu", inversedBy="partie", cascade={"persist", "remove"})
     */
    private $plateauDeJeu;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Utilisateur", inversedBy="partiesRejoins")
     */
    private $joueurs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="partiesCree")
     * @ORM\JoinColumn(nullable=false)
     */
    private $createur;

    /**
     * @ORM\Column(type="smallint")
     */
    private $nbPlateaux;

    /**
     * @ORM\Column(type="smallint")
     */
    private $nbPionParPlateau;

    /**
     * @ORM\Column(type="smallint")
     */
    private $nbFacesDe;

    /**
     * @ORM\Column(type="boolean")
     */
    private $estLance;

    public function __construct()
    {
        $this->joueurs = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getPlateau(): ?Plateau
    {
        return $this->plateau;
    }

    public function setPlateau(?Plateau $plateau): self
    {
        $this->plateau = $plateau;

        return $this;
    }

    public function getPlateauDeJeu(): ?PlateauEnJeu
    {
        return $this->plateauDeJeu;
    }

    public function setPlateauDeJeu(?PlateauEnJeu $plateauDeJeu): self
    {
        $this->plateauDeJeu = $plateauDeJeu;

        return $this;
    }

    /**
     * @return Collection|Utilisateur[]
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(Utilisateur $joueur): self
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs[] = $joueur;
        }

        return $this;
    }

    public function removeJoueur(Utilisateur $joueur): self
    {
        if ($this->joueurs->contains($joueur)) {
            $this->joueurs->removeElement($joueur);
        }

        return $this;
    }

    public function getCreateur(): ?Utilisateur
    {
        return $this->createur;
    }

    public function setCreateur(?Utilisateur $createur): self
    {
        $this->createur = $createur;

        return $this;
    }

    public function getNbPlateaux(): ?int
    {
        return $this->nbPlateaux;
    }

    public function setNbPlateaux(int $nbPlateaux): self
    {
        $this->nbPlateaux = $nbPlateaux;

        return $this;
    }

    public function getNbPionParPlateau(): ?int
    {
        return $this->nbPionParPlateau;
    }

    public function setNbPionParPlateau(int $nbPionParPlateau): self
    {
        $this->nbPionParPlateau = $nbPionParPlateau;

        return $this;
    }

    public function getNbFacesDe(): ?int
    {
        return $this->nbFacesDe;
    }

    public function setNbFacesDe(int $nbFacesDe): self
    {
        $this->nbFacesDe = $nbFacesDe;

        return $this;
    }

    public function getEstLance(): ?bool
    {
        return $this->estLance;
    }

    public function setEstLance(bool $estLance): self
    {
        $this->estLance = $estLance;

        return $this;
    }
}
