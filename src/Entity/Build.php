<?php

namespace App\Entity;

use App\Repository\BuildRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BuildRepository::class)]
class Build
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Weapon $weapon = null;

    #[ORM\ManyToOne]
    private ?Armor $Build = null;

    #[ORM\ManyToOne]
    private ?Armor $chest = null;

    #[ORM\ManyToOne]
    private ?Armor $arms = null;

    #[ORM\ManyToOne]
    private ?Armor $waist = null;

    #[ORM\ManyToOne]
    private ?Armor $legs = null;

    #[ORM\ManyToOne]
    private ?Armor $head = null;

    #[ORM\ManyToOne]
    private ?Charm $charm = null;

    /**
     * @var Collection<int, BuildDecoration>
     */
    #[ORM\OneToMany(targetEntity: BuildDecoration::class, mappedBy: 'build')]
    private Collection $buildDecorations;

    public function __construct()
    {
        $this->buildDecorations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getWeapon(): ?Weapon
    {
        return $this->weapon;
    }

    public function setWeapon(?Weapon $weapon): static
    {
        $this->weapon = $weapon;

        return $this;
    }

    public function getBuild(): ?Armor
    {
        return $this->Build;
    }

    public function setBuild(?Armor $Build): static
    {
        $this->Build = $Build;

        return $this;
    }

    public function getChest(): ?Armor
    {
        return $this->chest;
    }

    public function setChest(?Armor $chest): static
    {
        $this->chest = $chest;

        return $this;
    }

    public function getArms(): ?Armor
    {
        return $this->arms;
    }

    public function setArms(?Armor $arms): static
    {
        $this->arms = $arms;

        return $this;
    }

    public function getWaist(): ?Armor
    {
        return $this->waist;
    }

    public function setWaist(?Armor $waist): static
    {
        $this->waist = $waist;

        return $this;
    }

    public function getLegs(): ?Armor
    {
        return $this->legs;
    }

    public function setLegs(?Armor $legs): static
    {
        $this->legs = $legs;

        return $this;
    }

    public function getHead(): ?Armor
    {
        return $this->head;
    }

    public function setHead(?Armor $head): static
    {
        $this->head = $head;

        return $this;
    }

    public function getCharm(): ?Charm
    {
        return $this->charm;
    }

    public function setCharm(?Charm $charm): static
    {
        $this->charm = $charm;

        return $this;
    }

    /**
     * @return Collection<int, BuildDecoration>
     */
    public function getBuildDecorations(): Collection
    {
        return $this->buildDecorations;
    }

    public function addBuildDecoration(BuildDecoration $buildDecoration): static
    {
        if (!$this->buildDecorations->contains($buildDecoration)) {
            $this->buildDecorations->add($buildDecoration);
            $buildDecoration->setBuild($this);
        }

        return $this;
    }

    public function removeBuildDecoration(BuildDecoration $buildDecoration): static
    {
        if ($this->buildDecorations->removeElement($buildDecoration)) {
            // set the owning side to null (unless already changed)
            if ($buildDecoration->getBuild() === $this) {
                $buildDecoration->setBuild(null);
            }
        }

        return $this;
    }
}
