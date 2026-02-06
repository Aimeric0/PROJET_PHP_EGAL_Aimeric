<?php

namespace App\DataFixtures;

use App\Entity\Armor;
use App\Entity\ArmorSkill;
use App\Entity\Charm;
use App\Entity\CharmSkill;
use App\Entity\Decoration;
use App\Entity\Skill;
use App\Entity\Weapon;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpKernel\KernelInterface;

class AppFixtures extends Fixture
{
    private $projectDir;
    private $skillCache = []; // Pour retrouver les skills rapidement sans refaire de requêtes

    public function __construct(KernelInterface $kernel)
    {
        $this->projectDir = $kernel->getProjectDir();
    }

    public function load(ObjectManager $manager): void
    {
        echo "Début du chargement des Fixtures...\n";

        // 1. Charger les Skills en premier (car utilisés par les autres)
        $this->loadSkills($manager);
        
        // 2. Charger le reste
        $this->loadDecorations($manager);
        $this->loadCharms($manager);
        $this->loadWeapons($manager);
        
        // C'est ici que la magie opère pour tes armures
        $this->loadArmors($manager);

        $manager->flush();
        echo "✅ Toutes les données ont été chargées avec succès !\n";
    }

    private function loadSkills(ObjectManager $manager): void
    {
        $file = $this->projectDir . '/assets/data/skills.json';
        if (!file_exists($file)) return;

        $data = json_decode(file_get_contents($file), true);
        if (!$data) return;

        foreach ($data as $item) {
            $skill = new Skill();
            $skill->setName($item['name']);
            $skill->setMaxLevel(isset($item['ranks']) ? count($item['ranks']) : 1);
            $skill->setDescription($item['description'] ?? '');
            
            $manager->persist($skill);
            
            $this->skillCache[$item['name']] = $skill;
        }
        echo " - Skills chargés.\n";
    }

    private function loadArmors(ObjectManager $manager): void
    {
        $file = $this->projectDir . '/assets/data/armor.json';
        if (!file_exists($file)) {
            echo "ERREUR : Fichier armor.json introuvable ($file)\n";
            return;
        }

        $data = json_decode(file_get_contents($file), true);
        if (!$data) {
            echo "ERREUR : JSON invalide dans armor.json\n";
            return;
        }

        $content = file_get_contents($file);
        $data = json_decode($content, true);
    
    echo "DEBUG: Nombre d'éléments trouvés dans le JSON : " . count($data) . "\n";

        $count = 0;
        foreach ($data as $item) {
            if (empty($item['name'])) continue; 

            $armor = new Armor();
            $armor->setName($item['name']);
            
            $armor->setType(strtolower($item['kind'])); 

            $defense = 0;
            if (isset($item['defense']['base'])) {
                $defense = $item['defense']['base'];
            } elseif (isset($item['defense']) && is_numeric($item['defense'])) {
                $defense = $item['defense'];
            }
            $armor->setDefense((int)$defense);

            $armor->setSlots($item['slots'] ?? []);

            $manager->persist($armor);
            $count++;

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
        echo " - $count Armures chargées.\n";
    }

private function loadCharms(ObjectManager $manager): void
{
    $file = $this->projectDir . '/assets/data/charms.json';
    if (!file_exists($file)) return;

    $data = json_decode(file_get_contents($file), true);

    foreach ($data as $family) {
        if (!isset($family['ranks']) || !is_array($family['ranks'])) continue;

        foreach ($family['ranks'] as $rank) {
            $charm = new Charm();
            $charm->setName($rank['name'] ?? 'Unknown Charm');
            $charm->setRarity($rank['rarity'] ?? 1);
            $charm->setSlots($rank['slots'] ?? []); 

            $manager->persist($charm);

            $manager->flush();

            if (isset($rank['skills']) && is_array($rank['skills'])) {
                foreach ($rank['skills'] as $skillData) {
                    $skillName = $skillData['skill']['name'] ?? null;
                    $level = $skillData['level'] ?? 1;

                    if (!$skillName) {
                        continue;
                    }

                    $skill = $this->skillCache[$skillName] ?? null;

                    if (!$skill) {
                        continue;
                    }

                    $charmSkill = new CharmSkill();
                    $charmSkill->setCharm($charm);
                    $charmSkill->setSkill($skill);
                    $charmSkill->setLevel($level);

                    $manager->persist($charmSkill);
                    }
                }
            }
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
        echo " - Décorations chargées.\n";
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
        echo " - Armes chargées.\n";
    }
}