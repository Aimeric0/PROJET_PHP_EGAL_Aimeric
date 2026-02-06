<?php

namespace App\Entity;

use App\Repository\ArmorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArmorRepository::class)]
class Armor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    #[ORM\Column]
    private ?int $defense = null;

    #[ORM\Column(nullable: true)]
    private ?array $slots = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $imageName = null;

    /**
     * @var Collection<int, ArmorSkill>
     */
    #[ORM\OneToMany(targetEntity: ArmorSkill::class, mappedBy: 'armor', orphanRemoval: true)]
    private Collection $armorSkills;

    public function __construct()
    {
        $this->armorSkills = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getDefense(): ?int
    {
        return $this->defense;
    }

    public function setDefense(int $defense): static
    {
        $this->defense = $defense;

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

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageName(?string $imageName): static
    {
        $this->imageName = $imageName;

        return $this;
    }

    /**
     * @return Collection<int, ArmorSkill>
     */
    public function getArmorSkills(): Collection
    {
        return $this->armorSkills;
    }

    public function addArmorSkill(ArmorSkill $armorSkill): static
    {
        if (!$this->armorSkills->contains($armorSkill)) {
            $this->armorSkills->add($armorSkill);
            $armorSkill->setArmor($this);
        }

        return $this;
    }

    public function removeArmorSkill(ArmorSkill $armorSkill): static
    {
        if ($this->armorSkills->removeElement($armorSkill)) {
            // set the owning side to null (unless already changed)
            if ($armorSkill->getArmor() === $this) {
                $armorSkill->setArmor(null);
            }
        }

        return $this;
    }
}
