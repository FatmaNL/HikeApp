<?php

namespace App\Entity;

use App\Repository\ParticipationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ParticipationRepository::class)
 */
class Participation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idparticipation;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="participations")
     * @ORM\JoinColumn(nullable=false, referencedColumnName="cin")
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity=Evenement::class, inversedBy="participations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $evenement;

    public function getId(): ?int
    {
        return $this->idparticipation;
    }

    public function getClient(): ?User
    {
        return $this->client;
    }

    public function setClient(?User $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getEvenement(): ?Evenement
    {
        return $this->evenement;
    }

    public function setEvenement(?Evenement $evenement): self
    {
        $this->evenement = $evenement;

        return $this;
    }
}
