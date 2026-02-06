<?php

namespace App\Entity;

use App\Repository\CharmSkillRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CharmSkillRepository::class)]
class CharmSkill
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'charmSkills')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Charm $charm = null;

    public function getId(): ?int
    {
        return $this->id;
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
}
