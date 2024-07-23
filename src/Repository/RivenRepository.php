<?php

namespace App\Repository;

use App\Entity\Riven;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Riven>
 *
 * @method Riven|null find($id, $lockMode = null, $lockVersion = null)
 * @method Riven|null findOneBy(array $criteria, array $orderBy = null)
 * @method Riven[]    findAll()
 * @method Riven[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RivenRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Riven::class);
    }

//    /**
//     * @return Riven[] Returns an array of Riven objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Riven
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
