<?php

namespace App\Entity;

use App\Repository\EvenementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\TypeValidator;

/**
 * @ORM\Entity(repositoryClass=EvenementRepository::class)
 */
class Evenement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est obligatoire")
     * @Assert\Type(
     *     type="string",
     *     message="la valeur n'est pas valide {{ type }}."
     * )
     */
    private $depart;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est obligatoire")
     * @Assert\Type(
     *     type="string",
     *     message="la valeur n'est pas valide {{ type }}."
     * )
     */
    private $destination;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="ce champ est obligatoire")
     * @Assert\Length(max="2")
     * @Assert\Type(
     *     type="integer",
     *     message="la valeur n'est pas valide {{ type }}."
     * )
     */
    private $nbparticipant;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="ce champ est obligatoire")

     */
    private $dateevenement;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="ce champ est obligatoire")
     */
    private $duree;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(message="ce champ est obligatoire")
     */
    private $prix;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est obligatoire")
     */
    private $programme;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est obligatoire")
     */
    private $contact;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est obligatoire")
     */
    private $infos;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est obligatoire")
     */
    private $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\NotBlank(message="ce champ est obligatoire")
     */
    private $circuit;

    /**
     * @ORM\OneToMany(targetEntity=Sentier::class, mappedBy="randonnee")
     */
    private $sentiers;

    /**
     * @ORM\OneToMany(targetEntity=Transport::class, mappedBy="camping")
     */
    private $transports;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="ce champ est obligatoire")
     * @Assert\Type("string")
     * @Assert\Unique(message="ce nom est déja utilisé")
     */
    private $nomevenement;

    public function __construct()
    {
        $this->sentiers = new ArrayCollection();
        $this->transports = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepart(): ?string
    {
        return $this->depart;
    }

    public function setDepart(string $depart): self
    {
        $this->depart = $depart;

        return $this;
    }

    public function getDestination(): ?string
    {
        return $this->destination;
    }

    public function setDestination(string $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getNbparticipant(): ?int
    {
        return $this->nbparticipant;
    }

    public function setNbparticipant(int $nbparticipant): self
    {
        $this->nbparticipant = $nbparticipant;

        return $this;
    }

    public function getDateevenement(): ?\DateTimeInterface
    {
        return $this->dateevenement;
    }

    public function setDateevenement(\DateTimeInterface $dateevenement): self
    {
        $this->dateevenement = $dateevenement;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

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

    public function getProgramme(): ?string
    {
        return $this->programme;
    }

    public function setProgramme(string $programme): self
    {
        $this->programme = $programme;

        return $this;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function setContact(string $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getInfos(): ?string
    {
        return $this->infos;
    }

    public function setInfos(string $infos): self
    {
        $this->infos = $infos;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCircuit(): ?string
    {
        return $this->circuit;
    }

    public function setCircuit(?string $circuit): self
    {
        $this->circuit = $circuit;

        return $this;
    }

    /**
     * @return Collection|Sentier[]
     */
    public function getSentiers(): Collection
    {
        return $this->sentiers;
    }

    public function addSentier(Sentier $sentier): self
    {
        if (!$this->sentiers->contains($sentier)) {
            $this->sentiers[] = $sentier;
            $sentier->setRandonnee($this);
        }

        return $this;
    }

    public function removeSentier(Sentier $sentier): self
    {
        if ($this->sentiers->removeElement($sentier)) {
            // set the owning side to null (unless already changed)
            if ($sentier->getRandonnee() === $this) {
                $sentier->setRandonnee(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Transport[]
     */
    public function getTransports(): Collection
    {
        return $this->transports;
    }

    public function addTransport(Transport $transport): self
    {
        if (!$this->transports->contains($transport)) {
            $this->transports[] = $transport;
            $transport->setCamping($this);
        }

        return $this;
    }

    public function removeTransport(Transport $transport): self
    {
        if ($this->transports->removeElement($transport)) {
            // set the owning side to null (unless already changed)
            if ($transport->getCamping() === $this) {
                $transport->setCamping(null);
            }
        }

        return $this;
    }

    public function getNomevenement(): ?string
    {
        return $this->nomevenement;
    }

    public function setNomevenement(string $nomevenement): self
    {
        $this->nomevenement = $nomevenement;

        return $this;
    }


}
