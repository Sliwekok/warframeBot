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
        if (str_ends_with($item, "set") && str_starts_with($data, '<!DOCTYPE')) {
            $item = str_replace('_set', '', $item);
            $url = WarframeApiInterface::URL. WarframeApiInterface::URL_ITEMS. $item. WarframeApiInterface::URL_ORDER;
            $data = file_get_contents($url);
        }
        elseif (str_starts_with($data, '<!DOCTYPE') && str_starts_with($data, '<!DOCTYPE')) {
            $item = $item . '_blueprint';
            $url = WarframeApiInterface::URL. WarframeApiInterface::URL_ITEMS. $item. WarframeApiInterface::URL_ORDER;
            $data = file_get_contents($url);
        }
        $dataArr = json_decode($data, true);
        $dataPayload = $dataArr[WarframeApiInterface::FETCHED_PAYLOAD][WarframeApiInterface::FETCHED_PAYLOAD_ORDERS];
        if (($key = array_search(WarframeApiInterface::INCLUDE_ITEM_ORDERTYPE_BUY, $dataPayload)) !== false) {
            unset($dataPayload[$key]);
        }

        return (null === $dataPayload) ? false : true;
    }

    public function fetchList(string $name): array
    {
        $item = strtolower(preg_replace('/\s+/', '_', $name));
        $url = WarframeApiInterface::URL. WarframeApiInterface::URL_ITEMS. $item. WarframeApiInterface::URL_ORDER;
        $data = file_get_contents($url);
        if (str_ends_with($item, "set") && str_starts_with($data, '<!DOCTYPE')) {
            $item = str_replace('_set', '', $item);
            $url = WarframeApiInterface::URL. WarframeApiInterface::URL_ITEMS. $item. WarframeApiInterface::URL_ORDER;
            $data = file_get_contents($url);
        }
        elseif (str_starts_with($data, '<!DOCTYPE') && str_starts_with($data, '<!DOCTYPE')) {
            $item = $item . '_blueprint';
            $url = WarframeApiInterface::URL. WarframeApiInterface::URL_ITEMS. $item. WarframeApiInterface::URL_ORDER;
            $data = file_get_contents($url);
        }
        $dataArr = json_decode($data, true);
        $dataPayload = $dataArr[WarframeApiInterface::FETCHED_PAYLOAD][WarframeApiInterface::FETCHED_PAYLOAD_ORDERS];
        if (($key = array_search(WarframeApiInterface::INCLUDE_ITEM_ORDERTYPE_BUY, $dataPayload)) !== false) {
            unset($dataPayload[$key]);
        }

        return $dataPayload;
    }

    public function fetchItemData(string $name): array
    {
        $item = strtolower(preg_replace('/\s+/', '_', $name));
        $url = WarframeApiInterface::URL . WarframeApiInterface::URL_ITEMS . $item . WarframeApiInterface::URL_ORDER;

        return json_decode(file_get_contents($url, true), true)[WarframeApiInterface::FETCHED_INCLUDE];
    }
}
