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

class NotificationService
{

    public function __construct(
        private EntityManagerInterface  $entityManager,
        private NotificationsRepository $notificationsRepository
    ) {}

    public function handleData(array $data): int {
        $notifications = $this->notificationsRepository->getNotifications();
        $created = 0;
        foreach ($data as $offerId => $offerData) {
            // check if item already exists
            if (!$this->notificationExists($notifications, $offerData[ItemInterface::ENTITY_LOGINID], $offerId)) {
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

    public function notificationExists(
        array $notifications,
        int $loginId,
        int $itemId
    ): bool {
        $itemIdArr = array_column($notifications, NotificationsInterface::ENTITY_ITEMID);
        $loginIdArr = array_column($notifications, NotificationsInterface::ENTITY_LOGINID);

        if (
            is_null(array_search($loginId, $loginIdArr)) &&
            is_null(array_search($itemId, $itemIdArr))
        ) {

            return false;
        }

        return true;
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

}