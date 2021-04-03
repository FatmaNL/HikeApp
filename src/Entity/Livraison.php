<?php

namespace App\Entity;

use App\Repository\LivraisonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LivraisonRepository::class)
 */
class Livraison
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $date_livraison;

    /**
     * @ORM\ManyToOne(targetEntity=Livreur::class, inversedBy="livraisons")
     * @ORM\JoinColumn(nullable=false)
     */
    private $id_livreur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->date_livraison;
    }

    public function setDateLivraison(\DateTimeInterface $date_livraison): self
    {
        $this->date_livraison = $date_livraison;

        return $this;
    }

    public function getIdLivreur(): ?livreur
    {
        return $this->id_livreur;
    }

    public function setIdLivreur(?livreur $id_livreur): self
    {
        $this->id_livreur = $id_livreur;

        return $this;
    }
   
}
