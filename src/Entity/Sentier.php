<?php

namespace App\Entity;

use App\Repository\SentierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SentierRepository::class)
 */
class Sentier
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idsentier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomsentier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $duree;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $distance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $difficulte;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $departsentier;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $destinationsentier;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="sentiers")
     */
    private $randonnee;

    /**
     * @ORM\ManyToMany(targetEntity=Evenement::class, inversedBy="sentiers")
     * @JoinTable(name="evenements_sentiers")
     */
    private $evenements;

    public function __construct()
    {
        $this->evenements = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->idsentier;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getDistance(): ?string
    {
        return $this->distance;
    }

    public function setDistance(string $distance): self
    {
        $this->distance = $distance;

        return $this;
    }

    public function getDifficulte(): ?string
    {
        return $this->difficulte;
    }

    public function setDifficulte(string $difficulte): self
    {
        $this->difficulte = $difficulte;

        return $this;
    }

    public function getDepartsentier(): ?string
    {
        return $this->departsentier;
    }

    public function setDepartsentier(string $departsentier): self
    {
        $this->departsentier = $departsentier;

        return $this;
    }

    public function getDestinationsentier(): ?string
    {
        return $this->destinationsentier;
    }

    public function setDestinationsentier(string $destinationsentier): self
    {
        $this->destinationsentier = $destinationsentier;

        return $this;
    }

    public function getRandonnee(): ?Evenement
    {
        return $this->randonnee;
    }

    public function setRandonnee(?Evenement $randonnee): self
    {
        $this->randonnee = $randonnee;

        return $this;
    }

    public function getNomsentier(): ?string
    {
        return $this->nomsentier;
    }

    public function setNomsentier(string $nomsentier): self
    {
        $this->nomsentier = $nomsentier;

        return $this;
    }

    /**
     * @return Collection|Evenement[]
     */
    public function getEvenements(): Collection
    {
        return $this->evenements;
    }

    public function addEvenement(Evenement $evenement): self
    {
        if (!$this->evenements->contains($evenement)) {
            $this->evenements[] = $evenement;
            $evenement->setSentier($this);
        }

        return $this;
    }

    public function removeEvenement(Evenement $evenement): self
    {
        if ($this->evenements->removeElement($evenement)) {
            // set the owning side to null (unless already changed)
            if ($evenement->getSentier() === $this) {
                $evenement->setSentier(null);
            }
        }

        return $this;
    }
}
