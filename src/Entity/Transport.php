<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use App\Controller\EntityMangerInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=TransportRepository::class)
 */
class Transport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"eventgroup", "transgroup"})
     */
    private $idtransport;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"eventgroup", "transgroup"})
     * @Assert\NotBlank(message="ce champ est obligatoire")
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"eventgroup", "transgroup"})
     * @Assert\NotBlank(message="ce champ est obligatoire")
     * @Assert\Length(
     *      max = 2,
     *      maxMessage = "Erreur de validation"
     * )
     */
    private $volumemax;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"eventgroup", "transgroup"})
     * @Assert\NotBlank(message="ce champ est obligatoire")
     *  @Assert\Length(
     *      max = 2,
     *      maxMessage = "Erreur de validation"
     * )
     */
    private $nombre_transports;

    public function getIdtransport(): ?int
    {
        return $this->idtransport;
    }
    public function getId(): ?int
    {
        return $this->idtransport;
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

    public function getVolumemax(): ?int
    {
        return $this->volumemax;
    }

    public function setVolumemax(int $volumemax): self
    {
        $this->volumemax = $volumemax;

        return $this;
    }

    public function getNombreTransports(): ?int
    {
        return $this->nombre_transports;
    }

    public function setNombreTransports(int $nombre_transports): self
    {
        $this->nombre_transports = $nombre_transports;

        return $this;
    }
}
