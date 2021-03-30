<?php

namespace App\Entity;

use App\Repository\TransportRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TransportRepository::class)
 */
class Transport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $volumemax;

    /**
     * @ORM\Column(type="integer")
     */
    private $nombreTransports;

    public function getId(): ?int
    {
        return $this->id;
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
        return $this->nombreTransports;
    }

    public function setNombreTransports(int $nombreTransports): self
    {
        $this->nombreTransports = $nombreTransports;

        return $this;
    }
}
