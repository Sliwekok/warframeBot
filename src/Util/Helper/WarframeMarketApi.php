<?php

declare(strict_types=1);

namespace App\Util\Helper;

use App\UniqueNameInterface\WarframeApiInterface;

class WarframeMarketApi
{
    public function itemExists(string $name): bool
    {
        $item = strtolower(preg_replace('/\s+/', '_', $name));
        $url = WarframeApiInterface::URL. WarframeApiInterface::URL_ITEMS. $item. WarframeApiInterface::URL_ORDER;
        $data = file_get_contents($url);
        $dataArr = json_decode($data, true);

        return (null === $dataArr[WarframeApiInterface::FETCHED_PAYLOAD][WarframeApiInterface::PAYLOAD_ORDERS]) ? false : true;
    }

    public function fetchList(string $name): array
    {
        $item = strtolower(preg_replace('/\s+/', '_', $name));
        $url = WarframeApiInterface::URL . WarframeApiInterface::URL_ITEMS . $item . WarframeApiInterface::URL_ORDER;

        return json_decode(file_get_contents($url, true), true)[WarframeApiInterface::FETCHED_PAYLOAD][WarframeApiInterface::PAYLOAD_ORDERS];
    }

    public function fetchItemData(string $name): array
    {
        $item = strtolower(preg_replace('/\s+/', '_', $name));
        $url = WarframeApiInterface::URL . WarframeApiInterface::URL_ITEMS . $item . WarframeApiInterface::URL_ORDER;

        return json_decode(file_get_contents($url, true), true)[WarframeApiInterface::PAYLOAD_INCLUDE];
    }

    public function fetchRiven(string $name): array {
        $url = WarframeApiInterface::URL . WarframeApiInterface::URL_AUCTION. $name;
        // i don't know why it's blocking without it, other endpoints works fine
        ini_set('user_agent','Mozilla/4.0 (compatible; MSIE 6.0)');
        return json_decode(file_get_contents($url), true)[WarframeApiInterface::FETCHED_PAYLOAD][WarframeApiInterface::PAYLOAD_AUCTIONS];

    }

    public function fetchRivenAttributes(): array {
        $url = WarframeApiInterface::URL . WarframeApiInterface::URL_ATTRIBUTES;

        return json_decode(file_get_contents($url), true)[WarframeApiInterface::FETCHED_PAYLOAD][WarframeApiInterface::PAYLOAD_ATTRIBUTES];

    }
}
