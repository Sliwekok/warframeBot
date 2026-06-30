<?php

declare(strict_types=1);

namespace App\Service\Item;

use App\Repository\ItemTradableRepository;
use App\Service\WarframeMarket\MarketService;
use App\UniqueNameInterface\ItemInterface;
use App\Repository\ItemRepository;
use App\UniqueNameInterface\WarframeApiInterface;
use App\Util\Helper\WarframeMarketApi;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Service\Notification\NotificationService;

class ItemService
{

    public function __construct(
        private ItemRepository          $itemRepository,
        private WarframeMarketApi       $warframeMarketApi,
        private EntityManagerInterface  $entityManager,
        private NotificationService     $notificationService,
        private MarketService           $marketService,
        private ItemTradableRepository  $itemTradableRepository,
    ) {}

    public function validateData(
        array $data
    ): array {
        $msg = [];

        foreach ($data as $key => $value) {
            switch ($key) {
                case ItemInterface::FORM_NAME:
                    if (!is_string($value) && 3 >= strlen($value)) {
                        $msg += ['Name cannot be null'];
                    }
                    break;
                case ItemInterface::FORM_PRICE:
                    if (!is_numeric($value) && 1 >= (int)$value) {
                        $msg += ['Value must be bigger than 1 plat'];
                    }
                    break;
            }
        }

        return $msg;
    }

    public function addItemToWatchlist(
        array   $data,
        int     $loginId
    ): void {
        $item = new Item();
        $itemSelected = $this->itemTradableRepository->getSingle([ItemInterface::ENTITY_SLUG => $data[WarframeApiInterface::ITEM_NAME]]);
        $item
            ->setLoginId($loginId)
            ->setPlatformId((int)$data[ItemInterface::FORM_PLATFORMID])
            ->setPrice((int)$data[ItemInterface::FORM_PRICE])
            ->setType((string)$data[ItemInterface::FORM_TYPE])
            ->setStatus(ItemInterface::ITEM_STATUS_PLACED)
            ->setItem($itemSelected);
        ;
        $this->entityManager->persist($item);
        $this->entityManager->flush();
    }

    public function checkIfAlreadyWatched
    (
        int     $loginId,
        int     $platformId,
        int     $itemId
    ): bool
    {
        return (bool) $this->itemRepository->findOneBy([
            ItemInterface::ENTITY_ITEM_ID => $itemId,
            ItemInterface::ENTITY_LOGINID => $loginId,
            ItemInterface::ENTITY_PLATFORMID => $platformId
        ]);
    }

    public function itemExistsInApi(string $name): bool
    {
        return (!empty($this->warframeMarketApi->fetchItemData($name)));
    }

    public function getImageUrl(
        string  $name,
        string  $type,
        int     $explodeValue = 1,
        bool    $rivenUrl = false
    ): string {
        if (str_ends_with($name, ItemInterface::ITEM_NAME_PRIME)) {

            return $name;
        }

        if (str_contains(strtolower($type), ItemInterface::ITEM_TYPE_MOD)) {
            $extension = '.jpg';
        } else {
            $extension = '.png';
        }

        $exploded = explode('_', $name);

        if (!$rivenUrl) {
            unset($exploded[count($exploded) - $explodeValue]);
        }

        return implode('-', $exploded). $extension;
    }

    /**
     * delete Item and related notifications
     *
     * @param int $id
     */
    public function deleteItem(
        UserInterface   $user,
        int             $itemId
    ): void {
        $item = $this->itemRepository->findOneBy([
            ItemInterface::ENTITY_LOGINID => $user->getId(),
            ItemInterface::ENTITY_ID => $itemId
        ]);

        $this->notificationService->deleteNotifications($item);
        $this->entityManager->remove($item);
        $this->entityManager->flush();
    }

    public function editItem(
        UserInterface $user,
        array         $data
    ): void {
        $item = $this->itemRepository->findOneBy([
            ItemInterface::ENTITY_LOGINID => $user->getId(),
            ItemInterface::ENTITY_PLATFORMID => (int)$data[ItemInterface::FORM_PLATFORMID],
            ItemInterface::ENTITY_NAME => $data[ItemInterface::FORM_NAME]
        ]);

        $item->setPrice((int)$data[ItemInterface::FORM_PRICE]);
        $this->entityManager->flush();
    }

    public function getAllItems ()
    {
        $items = $this->itemTradableRepository->getList([]);

        return json_encode(['item' =>$items]);
    }
}
