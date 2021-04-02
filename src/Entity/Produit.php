<?php

namespace App\Entity;

use App\Repository\ProduitRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=ProduitRepository::class)
 * @UniqueEntity(
 * fields= {"nomproduit"},
 * message= "Le produit existe deja")
 */
class Produit
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $numproduit;

    /**
     *  @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "le numero de produit doit etre au minimum {{ limit }} caracteres",
     *      maxMessage = "le numero de produit doit etre au maximum {{ limit }} caracteres")
     * @ORM\Column(type="string", length=255)
     */
    public $nomproduit;

    /**
     * @ORM\Column(type="integer")
     */
    public $quantite;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive(
     *     message="la prix {{ value }} est invalide"
     * )
     */
    public $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    public $image;

    /**
     * @ORM\JoinColumn(name="cat", referencedColumnName="idcategorie")
     * @ORM\Column(type="integer")
     */
    public $cat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $catName;

    /**
     * @ORM\ManyToOne(targetEntity=Commande::class, inversedBy="produits")
     * @ORM\JoinColumn( referencedColumnName="refcommande")
     */
    private $commande;

    
   
     
    public function getId(): ?int
    {
        return $this->numproduit;
    }

    public function getNomproduit(): ?string
    {
        return $this->nomproduit;
    }

    public function setNomproduit(string $nomproduit): self
    {
        $this->nomproduit = $nomproduit;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage( $image)
    {
        $this->image = $image;

        return $this;
    }

    public function getCat(): ?string
    {
        
        return $this->cat;
    }

    public function setCat(?string $cat): self 
    {
        $this->cat = $cat;
       

        return $this;
    }

    public function getCatName(): ?string
    {
        return $this->catName;
    }

    public function setCatName(string $catName): self
    {
        $this->catName = $catName;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->commande;
    }

    public function setCommande(?Commande $commande): self
    {
        $this->commande = $commande;

        return $this;
    }

    
}
