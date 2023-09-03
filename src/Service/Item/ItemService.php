<?php

declare(strict_types=1);

namespace App\Service\Item;

use App\UniqueNameInterface\ItemInterface;
use App\Repository\ItemRepository;
use App\Util\Helper\WarframeMarketApi;
use App\Entity\Item;
use Doctrine\ORM\EntityManagerInterface;

class ItemService
{

    public function __construct(
        private ItemRepository          $itemRepository,
        private WarframeMarketApi       $warframeMarketApi,
        private EntityManagerInterface  $entityManager
    ) {}

    public function addItemToWatchlist(
        array   $data,
        int     $loginId
    ): void {
        $item = new Item();
        $item
            ->setLoginId($loginId)
            ->setName($data[ItemInterface::FORM_NAME])
            ->setPlatformId((int)$data[ItemInterface::FORM_PLATFORMID])
            ->setPrice((int)$data[ItemInterface::FORM_PRICE])
            ->setNameCurl(strtolower(preg_replace('/\s+/', '_', $data[ItemInterface::FORM_NAME])))
        ;
        $this->entityManager->persist($item);
//        $this->entityManager->flush();
    }

    public function checkIfAlreadyWatched
    (
        int     $loginId,
        int     $platformId,
        string  $name
    ): bool
    {
        return (bool) $this->itemRepository->findOneBy([
            ItemInterface::ENTITY_NAME => $name,
            ItemInterface::ENTITY_LOGINID => $loginId,
            ItemInterface::ENTITY_PLATFORMID => $platformId
        ]);
    }

    public function itemExistsInApi(string $name): bool
    {
        return $this->warframeMarketApi->itemExists($name);
    }
}