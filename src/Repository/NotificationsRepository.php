<?php

namespace App\Repository;

use App\Entity\Notifications;
use Doctrine\Persistence\ManagerRegistry;
use App\UniqueNameInterface\NotificationsInterface;

/**
 * @extends BaseRepository<Notifications>
 *
 * @method Notifications|null find($id, $lockMode = null, $lockVersion = null)
 * @method Notifications|null findOneBy(array $criteria, array $orderBy = null)
 * @method Notifications[]    findAll()
 * @method Notifications[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NotificationsRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Notifications::class);
    }

    public function getItemNotifications(): array {
        $isRead = NotificationsInterface::ENTITY_ISREAD;
        $id = NotificationsInterface::ENTITY_ID;
        $loginId = NotificationsInterface::ENTITY_LOGINID;
        $itemId = NotificationsInterface::ENTITY_ITEMID;
        $createdAt = NotificationsInterface::ENTITY_CREATED_AT;
        $today = (new \DateTime())->format('Y-m-d H:i:s');

        return $this->createQueryBuilder('n')
                ->select("n.$id as $id")
                ->addSelect("n.$loginId as $loginId")
                ->addSelect("n.$itemId as $itemId")
                ->where("n.$isRead = 0")
                ->orWhere("$createdAt >= ". $today)
                ->getQuery()
                ->getArrayResult()
            ;
    }

    public function getRivenNotifications(): array {
        $isRead = NotificationsInterface::ENTITY_ISREAD;
        $id = NotificationsInterface::ENTITY_ID;
        $loginId = NotificationsInterface::ENTITY_LOGINID;
        $rivenId = NotificationsInterface::ENTITY_RIVENID;
        $createdAt = NotificationsInterface::ENTITY_CREATED_AT;
        $today = (new \DateTime())->format('Y-m-d H:i:s');

        return $this->createQueryBuilder('n')
            ->select("n.$id as $id")
            ->addSelect("n.$loginId as $loginId")
            ->addSelect("n.$rivenId as $rivenId")
            ->where("n.$isRead = 0")
            ->orWhere("$createdAt >= ". $today)
            ->getQuery()
            ->getArrayResult()
        ;
    }

}
