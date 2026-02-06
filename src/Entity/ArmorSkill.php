<?php

namespace App\Entity;

use App\Repository\ArmorSkillRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArmorSkillRepository::class)]
class ArmorSkill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'armorSkills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Armor $armor = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Skill $skil = null;

    #[ORM\Column]
    private ?int $level = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArmor(): ?Armor
    {
        return $this->armor;
    }

    public function setArmor(?Armor $armor): static
    {
        $this->armor = $armor;

        return $this;
    }

    public function getSkil(): ?Skill
    {
        return $this->skil;
    }

    public function setSkil(?Skill $skil): static
    {
        $this->skil = $skil;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;

        return $this;
    }
}
