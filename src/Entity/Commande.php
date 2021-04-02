<?php

namespace App\Entity;

use App\Repository\CommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CommandeRepository::class)
 * @UniqueEntity(
 * fields= {"refcommande"},
 * message= "La reference est deja utilisée")
 */
class Commande
{

    /**
     * @ORM\Id
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="reference cannot be empty")
     * @Assert\Length(min="1",max="20")
     */
    private $refcommande;

    /**
     * @ORM\Column(type="date")
     */
    private $datecommande;

    /**
     * @ORM\Column(type="string", length=250)
     * @Assert\NotBlank(message="state cannot be empty")
     * @Assert\Length(min="3",max="20")
     */
    private $etat;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="commande")
     */
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

   


    
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

    /**
     * @return Collection|Produit[]
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(Produit $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
            $produit->setCommande($this);
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCommande() === $this) {
                $produit->setCommande(null);
            }
        }

        return $this;
    }

   




}
