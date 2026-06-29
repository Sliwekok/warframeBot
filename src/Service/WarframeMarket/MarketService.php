<?php

declare(strict_types=1);

namespace App\Service\WarframeMarket;

use App\Util\Helper\WarframeMarketApi;
use App\Repository\ItemRepository;
use App\Repository\RivenRepository;
use App\UniqueNameInterface\WarframeApiInterface;
use App\UniqueNameInterface\ItemInterface;
use App\Util\Helper\RivenAttributeHelper;

class MarketService
{

    public function __construct(
        private WarframeMarketApi       $warframeMarketApi,
        private ItemRepository          $itemRepository,
        private RivenRepository         $rivenRepository,
        private RivenAttributeHelper    $attributeHelper,
    ) {}

    public function getWarframeMarketData(
        string $slug,
        string $type = ''
    ): array {

        $matched = $this->warframeMarketApi->fetchList($slug);
        // sorting by price
        usort($matched, function ($a, $b) { return
            [$a[WarframeApiInterface::MARKET_USER][WarframeApiInterface::MARKET_USER_STATUS], $a[WarframeApiInterface::MARKET_PLATINUM]]
            <=>
            [$b[WarframeApiInterface::MARKET_USER][WarframeApiInterface::MARKET_USER_STATUS], $b[WarframeApiInterface::MARKET_PLATINUM]];
        });

        foreach ($matched as $key => $item) {
            if ($item[WarframeApiInterface::MARKET_USER_VISISBLE] === false) {
                unset($matched[$key]);
            }

            if (!empty($type)) {
                if ($item[WarframeApiInterface::ITEM_TYPE] !== $type) {
                    unset($matched[$key]);
                }
            }
        }

        return $matched;
    }

    public function getWarframeMarketDataRiven(
        string $rivenName
    ): array {
        $matched = $this->warframeMarketApi->fetchRiven($rivenName);
        // sorting by price
        usort($matched, function ($a, $b) { return
            [$a[WarframeApiInterface::AUCTION_BUYOUT]]
            <=>
            [$b[WarframeApiInterface::AUCTION_BUYOUT]];
        });

        return $matched;
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

        return $matched;
    }

    public function scanRivens(): array {
        $rivens = $this->rivenRepository->findAll();
        $matched = [];
        foreach ($rivens as $riven) {
            $scannedRivens = $this->getWarframeMarketDataRiven($riven->getNameCurl());

            foreach ($scannedRivens as $auction => $value) {
                /**
                 * check price of riven
                 */
                if ($value[WarframeApiInterface::AUCTION_BUYOUT] <= $riven->getPrice()) {
                    $matched[$riven->getId()] = $value;
                    $matched[$riven->getId()][ItemInterface::ENTITY_LOGINID] = $riven->getLogin()->getId();
                }

                /**
                 * sorting by riven attributes
                 * if it doesn't match then delete from matched
                 */
                if ($riven->hasAnyAttribute()) {
                    foreach ($value[WarframeApiInterface::AUCTION_ITEM][WarframeApiInterface::AUCTION_ITEM_ATTRIBUTES] as $attributes) {

                    }
                }

            }

        }

        return $matched;
    }

    public function getAllItems (): array
    {
        return $this->warframeMarketApi->fetchItems();
    }

    public function getItemData(string $itemName): array {
        return $this->warframeMarketApi->fetchItemData($itemName);
    }

}
