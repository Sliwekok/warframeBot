<?php

declare(strict_types=1);

namespace App\Service\Notification;

use App\Entity\Notifications;
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
        private ItemRepository          $itemRepository
    ) {}

    public function handleData(array $data): int {
        $notifications = $this->notificationsRepository->getNotifications();
        $created = 0;
        $itemIdArr = array_column($notifications, NotificationsInterface::ENTITY_ITEMID);
        $loginIdArr = array_column($notifications, NotificationsInterface::ENTITY_LOGINID);

        foreach ($data as $offerId => $offerData) {
            // check if item already exists
            if ($this->notificationNotExists($offerData[ItemInterface::ENTITY_LOGINID], $offerId, $itemIdArr, $loginIdArr)) {
                $this->createNotification(
                    $offerData[ItemInterface::ENTITY_LOGINID],
                    $offerId,
                    $offerData[WarframeApiInterface::MARKET_USER][WarframeApiInterface::MARKET_USER_INGAMENAME],
                    $offerData[WarframeApiInterface::MARKET_PLATINUM]
                );

                $created++;
            }
        }

        return $created;
    }

    public function notificationNotExists(
        int     $loginId,
        int     $itemId,
        array   $itemIdArr,
        array   $loginIdArr,
    ): bool {
        return (is_null(array_search($loginId, $loginIdArr)) && is_null(array_search($itemId, $itemIdArr)));
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
            $item = $this->itemRepository->find($notification->getItemId());
            $notification->item = $item;
        }

        return $notifications;
    }

    /**
     * @param Notifications[] $notifications
     */
    public function setAsRead(array $notifications): void {
        foreach ($notifications as $notification) {
            $notification->setIsRead(true);
            $this->entityManager->persist($notification);
        }

        $this->entityManager->flush();
    }

}