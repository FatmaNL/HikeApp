<?php

namespace App\Entity;

use App\Repository\LignecommandeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * @ORM\Entity(repositoryClass=LignecommandeRepository::class)
 */
class Lignecommande
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Assert\Positive
     * @Assert\NotBlank
     */
    private $idlignecommande;

    /**
     * @ORM\Column(type="integer")
     * @Assert\Positive
     * @Assert\NotBlank
     */
    private $qtecommande;

    /**
     * @ORM\OneToMany(targetEntity=Produit::class, mappedBy="Panier")
     * @ORM\JoinColumn(name="numproduit", referencedColumnName="numproduit")
     */
    private $Listeproduits;

    public function __construct()
    {
        $this->Listeproduits = new ArrayCollection();
    }



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

    /**
     * @return Collection|Produit[]
     */
    public function getListeproduits(): Collection
    {
        return $this->Listeproduits;
    }

    public function addListeproduit(Produit $listeproduit): self
    {
        if (!$this->Listeproduits->contains($listeproduit)) {
            $this->Listeproduits[] = $listeproduit;
            $listeproduit->setPanier($this);
        }

        return $this;
    }

    public function removeListeproduit(Produit $listeproduit): self
    {
        if ($this->Listeproduits->removeElement($listeproduit)) {
            // set the owning side to null (unless already changed)
            if ($listeproduit->getPanier() === $this) {
                $listeproduit->setPanier(null);
            }
        }

        return $this;
    }


}
