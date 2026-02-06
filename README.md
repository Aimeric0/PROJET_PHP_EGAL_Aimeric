# BuildMHWilds

BuildMHWilds est une application web développée en **Symfony PHP** qui permet de créer et gérer des builds pour le jeu **Monster Hunter Wilds**. L'objectif est de combiner armes, armures, charms et décorations pour optimiser vos personnages selon vos préférences de jeu.

---

## 🛠 Technologies utilisées

- **Symfony 6** (PHP)
- **Doctrine ORM** pour la gestion de la base de données
- **Twig** pour le templating
- **MySQL** pour la base de données
- **CSS personnalisé** avec un thème Dark Mode et couleurs indigo inspirées de Radix-UI
- **Fixtures** pour remplir la base de données avec les armes, armures, charms, décorations et skills du jeu

---

## 🚀 Fonctionnalités

- Authentification : Inscription / Connexion
- Création et modification de builds
- Sélection d'armes, armures, charms

---

## 📦 Structure de la base de données

- `User` : utilisateurs du site
- `Weapon` : armes
- `Armor` : armures
- `Charm` : charms
- `Decoration` : décorations
- `ArmorSkill` / `CharmSkill` : tables pivot pour gérer les skills liés

---

## ⚙ Installation

1. Cloner le dépôt :

```bash
git clone https://github.com/ton-utilisateur/PROJET_PHP_EGAL_Aimerics.git
cd PROJET_PHP_EGAL_Aimeric

composer install
php bin/console doctrine:database:create
php bin/console make:migration             
php bin/console doctrine:migrations:migrate   
php bin/console doctrine:fixtures:load  
symfony serve
Et le projet est lancé
