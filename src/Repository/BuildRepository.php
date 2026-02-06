<?php

namespace App\Repository;

use App\Entity\Armor;
use App\Entity\Build;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Build>
 *
 * @method Build|null find($id, $lockMode = null, $lockVersion = null)
 * @method Build|null findOneBy(array $criteria, array $orderBy = null)
 * @method Build[]    findAll()
 * @method Build[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BuildRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Build::class);
    }

    /**
     * Méthode pour sauvegarder ou mettre à jour un build
     */
    public function save(Build $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Méthode pour supprimer un build
     */
    public function remove(Build $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
     * Exemple : Récupérer les derniers builds créés (pour la page d'accueil)
     * @return Build[]
     */
    public function findLatestBuilds(int $limit = 10): array
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC') // Ou une colonne 'createdAt' si tu en as une
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    /**
     * Fonction avancée : Trouver tous les builds qui utilisent une pièce d'armure spécifique
     * Très utile pour une page "Détail de l'armure" -> "Builds utilisant cet objet"
     */
    public function findBuildsContainingArmor(Armor $armor): array
    {
        return $this->createQueryBuilder('b')
            ->where('b.head = :armor')
            ->orWhere('b.chest = :armor')
            ->orWhere('b.arms = :armor')
            ->orWhere('b.waist = :armor')
            ->orWhere('b.legs = :armor')
            ->setParameter('armor', $armor)
            ->orderBy('b.id', 'DESC')
            ->getQuery()
            ->getResult();
    }
}
