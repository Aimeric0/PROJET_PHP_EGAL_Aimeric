<?php

namespace App\Entity;

use App\Repository\CharmRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharmRepository::class)]
class Charm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?array $slots = null;

    #[ORM\Column]
    private ?int $rarity = null;

    /**
     * @var Collection<int, CharmSkill>
     */
    #[ORM\OneToMany(targetEntity: CharmSkill::class, mappedBy: 'charm', orphanRemoval: true)]
    private Collection $charmSkills;

    public function __construct()
    {
        $this->charmSkills = new ArrayCollection();
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

    public function getSlots(): ?array
    {
        return $this->slots;
    }

    public function setSlots(?array $slots): static
    {
        $this->slots = $slots;

        return $this;
    }

    public function getRarity(): ?int
    {
        return $this->rarity;
    }

    public function setRarity(int $rarity): static
    {
        $this->rarity = $rarity;

        return $this;
    }

    /**
     * @return Collection<int, CharmSkill>
     */
    public function getCharmSkills(): Collection
    {
        return $this->charmSkills;
    }

    public function addCharmSkill(CharmSkill $charmSkill): static
    {
        if (!$this->charmSkills->contains($charmSkill)) {
            $this->charmSkills->add($charmSkill);
            $charmSkill->setCharm($this);
        }

        return $this;
    }

    public function removeCharmSkill(CharmSkill $charmSkill): static
    {
        if ($this->charmSkills->removeElement($charmSkill)) {
            // set the owning side to null (unless already changed)
            if ($charmSkill->getCharm() === $this) {
                $charmSkill->setCharm(null);
            }
        }

        return $this;
    }
}
