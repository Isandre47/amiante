<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 06/06/2020 00:06
 *
 */

namespace App\Entity;

use App\Repository\ProcessRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProcessRepository::class)
 */
class Process
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="text")
     */
    private $processing;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $rate;

    /**
     * @ORM\ManyToMany(targetEntity=Zone::class, inversedBy="processes")
     */
    private $zone;

    public function __construct()
    {
        $this->zones = new ArrayCollection();
        $this->zone = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getProcessing(): ?string
    {
        return $this->processing;
    }

    public function setProcessing(string $processing): self
    {
        $this->processing = $processing;

        return $this;
    }

    public function getRate(): ?string
    {
        return $this->rate;
    }

    public function setRate(string $rate): self
    {
        $this->rate = $rate;

        return $this;
    }

    /**
     * @return Collection|Zone[]
     */
    public function getZone(): Collection
    {
        return $this->zone;
    }

    public function addZone(Zone $zone): self
    {
        if (!$this->zone->contains($zone)) {
            $this->zone[] = $zone;
        }

        return $this;
    }

    public function removeZone(Zone $zone): self
    {
        if ($this->zone->contains($zone)) {
            $this->zone->removeElement($zone);
        }

        return $this;
    }
}
