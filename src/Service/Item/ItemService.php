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
        $itemCurlName = strtolower(preg_replace('/\s+/', '_', $data[ItemInterface::FORM_NAME]));
        $item
            ->setLoginId($loginId)
            ->setName($data[ItemInterface::FORM_NAME])
            ->setPlatformId((int)$data[ItemInterface::FORM_PLATFORMID])
            ->setPrice((int)$data[ItemInterface::FORM_PRICE])
            ->setType((string)$data[ItemInterface::FORM_TYPE])
            ->setNameCurl($itemCurlName)
            ->setWikiUrl($this->checkWikiUrl($itemCurlName, $data[ItemInterface::FORM_TYPE]))
        ;
        $this->entityManager->persist($item);
        $this->entityManager->flush();
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

    private function checkWikiUrl(string $name, string $type): string {
        if (str_ends_with($name, ItemInterface::ITEM_NAME_PRIME)) {

            return $name;
        }
        $exploded = explode('_', $name);
        unset($exploded[count($exploded) - 1]);

        // warframe wiki has different ways to create urls for warframes somehow
        if (ItemInterface::ITEM_TYPE_WARFRAME === strtolower($type)) {
            $newUrl = implode('/', array_map('ucfirst', $exploded));
        } else {
            $newUrl = implode('_', array_map('ucfirst', $exploded));
        }

        return $newUrl;
    }
}