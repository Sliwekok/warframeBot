<?php

namespace App\Repository;

use App\Entity\Notifications;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use App\UniqueNameInterface\NotificationsInterface;

/**
 * @extends ServiceEntityRepository<Notifications>
 *
 * @method Notifications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notifications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notifications[]    findAll()
 * @method Notifications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notifications::class);
    }

    public function getNotifications(): array {
        $isRead = NotificationsInterface::ENTITY_ISREAD;
        $id = NotificationsInterface::ENTITY_ID;
        $loginId = NotificationsInterface::ENTITY_LOGINID;
        $itemId = NotificationsInterface::ENTITY_ITEMID;

        return $this->createQueryBuilder('n')
                ->select("n.$id as $id")
                ->addSelect("n.$loginId as $loginId")
                ->addSelect("n.$itemId as $itemId")
                ->where("n.$isRead = 0")
                ->getQuery()
                ->getArrayResult()
            ;
    }

}
