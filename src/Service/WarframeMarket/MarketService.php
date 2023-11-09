<?php

declare(strict_types=1);

namespace App\Service\WarframeMarket;

use App\Util\Helper\WarframeMarketApi;
use App\Repository\ItemRepository;
use App\UniqueNameInterface\WarframeApiInterface;
use App\UniqueNameInterface\ItemInterface;

class MarketService
{

    public function __construct(
        private WarframeMarketApi       $warframeMarketApi,
        private ItemRepository          $itemRepository
    ) {}

    public function getWarframeMarketData (
        string $itemName
    ): array {

        return $this->warframeMarketApi->fetchList($itemName);
    }

    public function scanMarket(): array {
        $items = $this->itemRepository->findAll();
        $matched = [];
        foreach ($items as $item) {
            // we want only first array key since we seek for lowest price
            $scannedMarket = $this->getWarframeMarketData($item->getName())[0];

            if ($scannedMarket[WarframeApiInterface::MARKET_PLATINUM] <= $item->getPrice()) {
                $matched[$item->getId()] = $scannedMarket;
                $matched[$item->getId()][ItemInterface::ENTITY_LOGINID] = $item->getLoginId();
            }
        }

        usort($matched, function ($a, $b) {return $a[WarframeApiInterface::MARKET_PLATINUM] > $b[WarframeApiInterface::MARKET_PLATINUM];});

        return $matched;
    }
}