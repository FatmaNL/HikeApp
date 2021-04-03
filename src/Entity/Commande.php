<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 */
class Commande
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     */
    private $refcommande;

    /**
     * @ORM\Column(type="date")
     */
    private $datecommande;

    /**
     * @ORM\Column(type="string", length=250)
     */
    private $etat;


    public function getrefcommande(): ?string
    {
        return $this->refcommande;
    }
    public function setrefcommande(string $refcommande): self
    {
        $this->refcommande = $refcommande;

        return $this;
    }


    public function getDatecommande(): ?\DateTimeInterface
    {
        return $this->datecommande;
    }


    public function setDatecommande(\DateTimeInterface $datecommande): self
    {
        $this->datecommande = $datecommande;

        return $this;
    }

    public function getEtat(): ?string
    {
        //commented
        return $this->etat;
    }

    public function setEtat(string $etat): self
    {
        $this->etat = $etat;

        return $this;
    }




}
