<?php

namespace App\Entity;

use App\Repository\LignefactureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LignefactureRepository::class)
 */
class Lignefacture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idlignefacture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomfacture;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $descriptionfacture;

    /**
     * @ORM\Column(type="integer")
     */
    private $montantlignefacture;

    /**
     * @ORM\Column(type="integer")
     */
    private $qteproduits;

    public function getId(): ?int
    {
        return $this->idlignefacture;
    }

    public function getNomfacture(): ?string
    {
        return $this->nomfacture;
    }

    public function setNomfacture(string $nomfacture): self
    {
        $this->nomfacture = $nomfacture;

        return $this;
    }

    public function getDescriptionfacture(): ?string
    {
        return $this->descriptionfacture;
    }

    public function setDescriptionfacture(string $descriptionfacture): self
    {
        $this->descriptionfacture = $descriptionfacture;

        return $this;
    }

    public function getMontantlignefacture(): ?int
    {
        return $this->montantlignefacture;
    }

    public function setMontantlignefacture(int $montantlignefacture): self
    {
        $this->montantlignefacture = $montantlignefacture;

        return $this;
    }

    public function getQteproduits(): ?int
    {
        return $this->qteproduits;
    }

    public function setQteproduits(int $qteproduits): self
    {
        $this->qteproduits = $qteproduits;

        return $this;
    }
}
