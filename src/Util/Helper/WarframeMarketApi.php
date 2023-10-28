<?php

declare(strict_types=1);

namespace App\Util\Helper;

use App\UniqueNameInterface\WarframeApi;

class WarframeMarketApi
{
    public function itemExists(string $name): bool {
        $item = strtolower(preg_replace('/\s+/', '_', $name));
        $url = WarframeApi::URL. WarframeApi::URL_ITEMS. $item. WarframeApi::URL_ORDER;
        $data = file_get_contents($url);
        $dataArr = json_decode($data, true);

        return (null === $dataArr[WarframeApi::FETCHED_PAYLOAD][WarframeApi::FETCHED_ORDERS]) ? false : true;
    }

    public function fetchList(string $name): array
    {
        $item = strtolower(preg_replace('/\s+/', '_', $name));
        $url = WarframeApi::URL . WarframeApi::URL_ITEMS . $item . WarframeApi::URL_ORDER;

        return json_decode(file_get_contents($url, true), true)[WarframeApi::FETCHED_PAYLOAD][WarframeApi::FETCHED_ORDERS];
    }
}