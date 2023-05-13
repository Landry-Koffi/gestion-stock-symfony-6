<?php

namespace App\Repository;

use App\Entity\ProduitCommandeClient;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ProduitCommandeClient>
 *
 * @method ProduitCommandeClient|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProduitCommandeClient|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProduitCommandeClient[]    findAll()
 * @method ProduitCommandeClient[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProduitCommandeClientRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProduitCommandeClient::class);
    }

    public function save(ProduitCommandeClient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ProduitCommandeClient $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return ProduitCommandeClient[] Returns an array of ProduitCommandeClient objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ProduitCommandeClient
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
