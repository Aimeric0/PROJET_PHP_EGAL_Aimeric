<?php

namespace App\DataFixtures;

use App\Entity\Armor;
use App\Entity\ArmorSkill;
use App\Entity\Charm;
use App\Entity\CharmSkill;
use App\Entity\Decoration;
use App\Entity\Skill;
use App\Entity\User;
use App\Entity\Weapon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private $projectDir;
    private $passwordHasher;
    private $skillCache = [];

    public function __construct(
        KernelInterface $kernel,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->projectDir = $kernel->getProjectDir();
        $this->passwordHasher = $passwordHasher;
    }

    public function load(ObjectManager $manager): void
    {
        $this->loadSkills($manager);
        $this->loadDecorations($manager);
        $this->loadCharms($manager);
        $this->loadArmors($manager);
        $this->loadWeapons($manager);

        $this->createUser($manager, 'user@test.com', 'user123', ['ROLE_USER']);
        $this->createUser($manager, 'admin@test.com', 'admin123', ['ROLE_ADMIN']);
        $this->createUser($manager, 'superadmin@test.com', 'super123', ['ROLE_ADMIN', 'ROLE_SUPER_ADMIN']);

        $manager->flush();
    }

    private function loadSkills(ObjectManager $manager): void
    {
        $file = $this->projectDir . '/assets/data/skills.json';
        if (!file_exists($file)) return;

        $data = json_decode(file_get_contents($file), true);
        foreach ($data as $item) {
            $skill = new Skill();
            $skill->setName($item['name']);
            $skill->setMaxLevel(isset($item['ranks']) ? count($item['ranks']) : 1);
            $skill->setDescription($item['description'] ?? '');

            $manager->persist($skill);
            $this->skillCache[$item['name']] = $skill;
        }
    }

    private function loadDecorations(ObjectManager $manager): void
    {
        $file = $this->projectDir . '/assets/data/decorations.json';
        if (!file_exists($file)) return;

        $data = json_decode(file_get_contents($file), true);

                foreach ($data as $item) {
            $deco = new Decoration();
            $deco->setName($item['name']);
            $deco->setSlotLevel($item['slot'] ?? 1);

            if (isset($item['icon'])) {
                $iconName = 'jewel_' . ($item['icon']['color'] ?? 'white') . '.png';
                $deco->setImageName($iconName);
            }

            if (!empty($item['skills']) && isset($item['skills'][0])) {
                $skillData = $item['skills'][0];
                $skillName = $skillData['skill']['name'] ?? '';
                $skillLevel = $skillData['level'] ?? 1;

                if (isset($this->skillCache[$skillName])) {
                    $deco->setSkill($this->skillCache[$skillName]);
                    $deco->setSkillLevel($skillLevel);
                }
            }

            $manager->persist($deco);
        }
    }

    private function loadCharms(ObjectManager $manager): void
    {
        $file = $this->projectDir . '/assets/data/charms.json';
        if (!file_exists($file)) return;

        $data = json_decode(file_get_contents($file), true);

        foreach ($data as $family) {
            if (!isset($family['ranks']) || !is_array($family['ranks'])) {
                continue;
            }

            foreach ($family['ranks'] as $rank) {
                $charm = new Charm();
                $charm->setName($rank['name'] ?? 'Unknown Charm');
                $charm->setRarity($rank['rarity'] ?? 1);
                $charm->setSlots($rank['slots'] ?? []);

                $manager->persist($charm);

                if (isset($rank['skills']) && is_array($rank['skills'])) {
                    foreach ($rank['skills'] as $skillData) {
                        $skillName = $skillData['skill']['name'] ?? null;
                        $level = $skillData['level'] ?? 1;

                        if ($skillName && isset($this->skillCache[$skillName])) {
                            $charmSkill = new CharmSkill();
                            $charmSkill->setCharm($charm);
                            $charmSkill->setSkill($this->skillCache[$skillName]);
                            $charmSkill->setLevel($level);

                            $manager->persist($charmSkill);
                        }
                    }
                }
            }
        }
    }

    private function loadArmors(ObjectManager $manager): void
    {
        $file = $this->projectDir . '/assets/data/armor.json';
        if (!file_exists($file)) return;

        $data = json_decode(file_get_contents($file), true);

        foreach ($data as $item) {
            if (empty($item['name'])) {
                continue;
            }

            $armor = new Armor();
            $armor->setName($item['name']);
            $armor->setType(strtoupper($item['kind'] ?? 'UNKNOWN'));

            $defense = 0;
            if (isset($item['defense']['base'])) {
                $defense = $item['defense']['base'];
            } elseif (is_numeric($item['defense'])) {
                $defense = $item['defense'];
            }
            $armor->setDefense((int)$defense);

            $armor->setSlots($item['slots'] ?? []);

            $manager->persist($armor);

            if (isset($item['skills']) && is_array($item['skills'])) {
                foreach ($item['skills'] as $skillData) {
                    $skillName = $skillData['skill']['name'] ?? null;
                    $level = $skillData['level'] ?? 1;

                    if ($skillName && isset($this->skillCache[$skillName])) {
                        $armorSkill = new ArmorSkill();
                        $armorSkill->setArmor($armor);
                        $armorSkill->setSkill($this->skillCache[$skillName]);
                        $armorSkill->setLevel((int)$level);

                        $manager->persist($armorSkill);
                    }
                }
            }
        }
    }

    private function loadWeapons(ObjectManager $manager): void
    {
        $file = $this->projectDir . '/assets/data/weapons.json';
        if (!file_exists($file)) return;

        $data = json_decode(file_get_contents($file), true);

        foreach ($data as $item) {
            $weapon = new Weapon();
            $weapon->setName($item['name']);
            $weapon->setType($item['kind'] ?? 'Unknown');

            $damage = 0;
            if (isset($item['damage']['display'])) {
                $damage = $item['damage']['display'];
            } elseif (isset($item['damage']['raw'])) {
                $damage = $item['damage']['raw'];
            } elseif (is_numeric($item['damage'])) {
                $damage = $item['damage'];
            }
            $weapon->setDamage((int)$damage);

            $weapon->setSlots($item['slots'] ?? []);

            $manager->persist($weapon);
        }
    }

    private function createUser(ObjectManager $manager, string $email, string $password, array $roles): void
    {
        $user = new User();
        $user->setEmail($email);
        $user->setRoles($roles);
        $user->setPassword($this->passwordHasher->hashPassword($user, $password));

        $manager->persist($user);
    }
}

