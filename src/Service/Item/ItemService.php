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
        $itemCurlName = strtolower(preg_replace('/\s+/', '_', $data[ItemInterface::FORM_NAME]));
        $itemWikiUrl = $this->getWikiUrl($itemCurlName, $data[ItemInterface::FORM_TYPE]);
        $itemImageUrl = $this->getImageUlr($itemCurlName);
        $item
            ->setLoginId($loginId)
            ->setName($data[ItemInterface::FORM_NAME])
            ->setPlatformId((int)$data[ItemInterface::FORM_PLATFORMID])
            ->setPrice((int)$data[ItemInterface::FORM_PRICE])
            ->setType((string)$data[ItemInterface::FORM_TYPE])
            ->setNameCurl($itemCurlName)
            ->setWikiUrl($itemWikiUrl)
            ->setImageUrl($itemImageUrl)
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

    private function getWikiUrl(string $name, string $type): string {
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

    private function getImageUlr(string $name): string {
        if (str_ends_with($name, ItemInterface::ITEM_NAME_PRIME)) {

            return $name;
        }
        $exploded = explode('_', $name);
        unset($exploded[count($exploded) - 1]);

        return implode('-', $exploded). '.png';
    }
}