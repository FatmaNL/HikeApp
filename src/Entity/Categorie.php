<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 * @UniqueEntity(
 * fields= {"nomcategorie"},
 * message= "La categorie existe deja")
 */
class Categorie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    public $idcategorie;

    /**
     *  @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "le nom du categorie doit etre au minimum {{ limit }} caracteres",
     *      maxMessage = "le nom du categorie doit etre au maximum {{ limit }} caracteres")
     * @ORM\Column(type="string", length=255)
     */
    public  $nomcategorie;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="cat",orphanRemoval=false)
     */
    private $produits;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
    }

    
    
    
    public function getId(): ?int
    {
        return $this->idcategorie;
    }

    public function getNomcategorie(): ?string
    {
        return $this->nomcategorie;
    }

    public function setNomcategorie(string $nomcategorie): self
    {
        $this->nomcategorie = $nomcategorie;

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
            dd($this);
            $produit->setCat('rrrr');
        }

        return $this;
    }

    public function removeProduit(Produit $produit): self
    {
        if ($this->produits->removeElement($produit)) {
            // set the owning side to null (unless already changed)
            if ($produit->getCat() === $this) {
                $produit->setCat(null);
            }
        }

        return $this;
    }

   
 
}
