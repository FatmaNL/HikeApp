<?php

namespace App\Entity;

use App\Repository\LignecommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LignecommandeRepository::class)
 */
class Lignecommande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idlignecommande;

    /**
     * @ORM\Column(type="integer")
     */
    private $qtecommande;

    public function getId(): ?int
    {
        return $this->idlignecommande;
    }

    public function getQtecommande(): ?int
    {
        return $this->qtecommande;
    }

    public function setQtecommande(int $qtecommande): self
    {
        $this->qtecommande = $qtecommande;

        return $this;
    }
}
