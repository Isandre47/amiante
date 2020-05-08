<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ZoneRepository")
 */
class Zone
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Site", inversedBy="zones")
     */
    private $site;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Initial", mappedBy="zone")
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

    public function __construct()
    {
        $this->initials = new ArrayCollection();
        $this->removals = new ArrayCollection();
        $this->outputs = new ArrayCollection();
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
}
