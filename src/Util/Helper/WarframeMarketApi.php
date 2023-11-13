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

        return (null === $dataArr[WarframeApiInterface::FETCHED_PAYLOAD][WarframeApiInterface::FETCHED_PAYLOAD_ORDERS]) ? false : true;
    }

    public function fetchList(string $name): array
    {
        $item = strtolower(preg_replace('/\s+/', '_', $name));
        $url = WarframeApiInterface::URL . WarframeApiInterface::URL_ITEMS . $item . WarframeApiInterface::URL_ORDER;

        return json_decode(file_get_contents($url, true), true)[WarframeApiInterface::FETCHED_PAYLOAD][WarframeApiInterface::FETCHED_PAYLOAD_ORDERS];
    }

    public function fetchItemData(string $name): array
    {
        $item = strtolower(preg_replace('/\s+/', '_', $name));
        $url = WarframeApiInterface::URL . WarframeApiInterface::URL_ITEMS . $item . WarframeApiInterface::URL_ORDER;

        return json_decode(file_get_contents($url, true), true)[WarframeApiInterface::FETCHED_INCLUDE];
    }
}