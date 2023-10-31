<?php

namespace App\Repository;

use App\Entity\Item;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Query\Parameter;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Item>
 *
 * @method Item|null find($id, $lockMode = null, $lockVersion = null)
 * @method Item|null findOneBy(array $criteria, array $orderBy = null)
 * @method Item[]    findAll()
 * @method Item[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ItemRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Item::class);
    }

//    public function findAllForUser(int $loginId): array {
//        $t = $this->createQueryBuilder('i')
//            ->select('i.name')
//            ->addSelect('i.price')
////            ->addSelect('p.name')
//            ->where('i.login_id = :platform_id')
//            ->setParameters([
//                'login_id' => $loginId,
//            ])
//            ->join('i.platform_id', 'p')
//            ->getQuery()
//            ->getResult()
//        ;
//        return $t
//            ;
//    }
}
