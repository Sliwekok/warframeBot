<?php

declare(strict_types=1);

namespace App\Service\Notification;

use App\Entity\Item;
use App\Entity\Notifications;
use App\Entity\Riven;
use App\Repository\RivenRepository;
use App\UniqueNameInterface\NotificationsInterface;
use Doctrine\ORM\EntityManagerInterface;
use App\UniqueNameInterface\WarframeApiInterface;
use App\UniqueNameInterface\ItemInterface;
use App\Repository\NotificationsRepository;
use DateTime;
use App\Repository\ItemRepository;

class NotificationService
{

    public function __construct(
        private EntityManagerInterface  $entityManager,
        private NotificationsRepository $notificationsRepository,
        private ItemRepository          $itemRepository,
        private RivenRepository         $rivenRepository
    ) {}

    public function notificationExists(
        int     $loginId,
        int     $itemId,
        string  $seller,
        int     $price,
    ): bool {
        $notification = $this->notificationsRepository->getSingle([
            NotificationsInterface::ENTITY_LOGINID => $loginId,
            NotificationsInterface::ENTITY_ITEMID => $itemId,
            NotificationsInterface::ENTITY_SELLER => $seller,
            NotificationsInterface::ENTITY_PRICE => $price,
                                                                  ]);

        return !empty($notification);
    }

    public function createNotification(
        int     $loginId,
        int     $itemId,
        string  $seller,
        int     $price
    ): void {
        $notification = new Notifications();
        $notification
            ->setLoginId($loginId)
            ->setItemId($itemId)
            ->setSeller($seller)
            ->setPrice($price)
            ->setIsRead(false)
            ->setDate(new DateTime('now'))
        ;

        $this->entityManager->persist($notification);
        $this->entityManager->flush();
    }

    /**
     * @param Notifications[] $notifications
     */
    public function getRelatedItems(array $notifications): array {
        foreach ($notifications as &$notification) {
            if (isset($notification[NotificationsInterface::ENTITY_RIVENID]) && $notification[NotificationsInterface::ENTITY_RIVENID] === null) {
                $riven = $this->rivenRepository->getSingle([
                    ItemInterface::ENTITY_ID => $notification[NotificationsInterface::ENTITY_RIVENID]
                ]);
                $notification[NotificationsInterface::ENTITY_ITEMID] = $riven;
            } else {
                $item = $this->itemRepository->getSingle([
                    ItemInterface::ENTITY_ID => $notification[NotificationsInterface::ENTITY_ITEMID]
                                                           ]);
                $notification[NotificationsInterface::ENTITY_ITEMID] = $item;
            }
        }

        return $notifications;
    }

    /**
     * @param Notifications[] $notifications
     */
    public function setAsRead(array $notifications): void {
        foreach ($notifications as $notification) {
            $object = $this->notificationsRepository->getSingle([
                NotificationsInterface::ENTITY_ID => $notification[NotificationsInterface::ENTITY_ID]
            ])->setIsRead(true);
            $this->entityManager->persist($object);
        }

        $this->entityManager->flush();
    }

    /**
     * delete all notifications related to item
     * @param Item[]|Riven[] $item
     */
    public function deleteNotifications(Item|Riven $item): void {
        if (Item::class === get_class($item)) {
            $notifications = $this->notificationsRepository->findBy([
                NotificationsInterface::ENTITY_ITEMID => $item->id
            ]);
        } else {
            $notifications = $this->notificationsRepository->findBy([
                NotificationsInterface::ENTITY_RIVENID => $item->id,
            ]);
        }

        foreach ($notifications as $notification) {
            $this->entityManager->remove($notification);
        }

        $this->entityManager->flush();
    }
}
