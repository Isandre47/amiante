<?php
/**
 *  Copyright (c) isandre.net
 *  Created by PhpStorm.
 *  User: Isandre47
 *  Date: 22/05/2020 20:06
 *
 */

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ZoneRepository")
 */
class Zone
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups("user-show")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups("user-show")
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="zones")
     */
    private $site;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Initial", mappedBy="zone")
     * @Groups("user-show")
     */
    private $initials;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Removal", mappedBy="zone")
     */
    private $removals;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Output", mappedBy="Zone")
     */
    private $outputs;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="zones")
     * @Groups("user-show")
     */
    private $category;

    /**
     * @ORM\Column(type="array")
     * @Groups("user-show")
     */
    private $fiber = [];

    /**
     * @ORM\ManyToMany(targetEntity=Process::class, mappedBy="zone")
     * @Groups("user-show")
     */
    private $processes;

    public function __construct()
    {
        $this->initials = new ArrayCollection();
        $this->removals = new ArrayCollection();
        $this->outputs = new ArrayCollection();
        $this->processes = new ArrayCollection();
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

    public function getSite(): ?Site
    {
        return $this->site;
    }

    public function setSite(?Site $site): self
    {
        $this->site = $site;

        return $this;
    }

    /**
     * @return Collection|Initial[]
     */
    public function getInitials(): Collection
    {
        return $this->initials;
    }

    public function addInitial(Initial $initial): self
    {
        if (!$this->initials->contains($initial)) {
            $this->initials[] = $initial;
            $initial->setZone($this);
        }

        return $this;
    }

    public function removeInitial(Initial $initial): self
    {
        if ($this->initials->contains($initial)) {
            $this->initials->removeElement($initial);
            // set the owning side to null (unless already changed)
            if ($initial->getZone() === $this) {
                $initial->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Removal[]
     */
    public function getRemovals(): Collection
    {
        return $this->removals;
    }

    public function addRemoval(Removal $removal): self
    {
        if (!$this->removals->contains($removal)) {
            $this->removals[] = $removal;
            $removal->setZone($this);
        }

        return $this;
    }

    public function removeRemoval(Removal $removal): self
    {
        if ($this->removals->contains($removal)) {
            $this->removals->removeElement($removal);
            // set the owning side to null (unless already changed)
            if ($removal->getZone() === $this) {
                $removal->setZone(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Output[]
     */
    public function getOutputs(): Collection
    {
        return $this->outputs;
    }

    public function addOutput(Output $output): self
    {
        if (!$this->outputs->contains($output)) {
            $this->outputs[] = $output;
            $output->setZone($this);
        }

        return $this;
    }

    public function removeOutput(Output $output): self
    {
        if ($this->outputs->contains($output)) {
            $this->outputs->removeElement($output);
            // set the owning side to null (unless already changed)
            if ($output->getZone() === $this) {
                $output->setZone(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getFiber(): ?array
    {
        return $this->fiber;
    }

    public function setFiber(array $fiber): self
    {
        $this->fiber = $fiber;

        return $this;
    }

    /**
     * @return Collection|Process[]
     */
    public function getProcesses(): Collection
    {
        return $this->processes;
    }

    public function addProcess(Process $process): self
    {
        if (!$this->processes->contains($process)) {
            $this->processes[] = $process;
            $process->addZone($this);
        }

        return $this;
    }

    public function removeProcess(Process $process): self
    {
        if ($this->processes->contains($process)) {
            $this->processes->removeElement($process);
            $process->removeZone($this);
        }

        return $this;
    }
}
