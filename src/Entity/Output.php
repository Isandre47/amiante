<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 22/05/2020 20:06
 *
 */

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OutputRepository")
 */
class Output
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("user-show")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups("user-show")
     */
    private $location;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Zone", inversedBy="outputs")
     * @Groups("user-show")
     */
    private $Zone;

    /**
     * @ORM\Column(type="date")
     * @Groups("user-show")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getZone(): ?Zone
    {
        return $this->Zone;
    }

    public function setZone(?Zone $Zone): self
    {
        $this->Zone = $Zone;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
