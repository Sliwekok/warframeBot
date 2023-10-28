<?php

declare(strict_types=1);

namespace App\Service\WarframeMarket;

use App\UniqueNameInterface\ItemInterface;
use App\Util\Helper\WarframeMarketApi;

class MarketService
{

    public function __construct(
        private WarframeMarketApi       $warframeMarketApi,
    ) {}


    public function getWarframeMarketData (
        string $itemName
    ): array {

        return $this->warframeMarketApi->fetchList($itemName);
    }
}