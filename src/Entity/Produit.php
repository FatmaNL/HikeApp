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
    private $numproduit;

    /**
     *  @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "le numero de produit doit etre au minimum {{ limit }} caracteres",
     *      maxMessage = "le numero de produit doit etre au maximum {{ limit }} caracteres")
     * @ORM\Column(type="string", length=255)
     */
    private $nomproduit;

    /**
     * @ORM\Column(type="integer")
     */
    private $quantite;

    /**
     * @ORM\Column(type="float")
     * @Assert\Positive(
     *     message="la prix {{ value }} est invalide"
     * )
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="produits")
     * @ORM\JoinColumn(name="cat", referencedColumnName="idcategorie")
     * @ORM\Column(type="integer")
     */
    public $cat;

    /**
     * @ORM\Column(type="string", length=255)
     */
    public $catName;
   
     
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
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

}
