<?php

namespace App\Entity;

use App\Repository\SentierRepository;
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
}