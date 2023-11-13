<?php

declare(strict_types=1);

namespace App\UniqueNameInterface;

class WarframeApiInterface
{
    public const URL = 'https://api.warframe.market/v1/';
    public const URL_ITEMS = 'items/';
    public const URL_ORDER = '/orders?include=item';

    public const FETCHED_PAYLOAD = 'payload';
    public const FETCHED_PAYLOAD_ORDERS = 'orders';
    public const FETCHED_INCLUDE = 'include';
    public const INCLUDE_ITEM = 'item';
    public const INCLUDE_ITEM_ITEMSINSET = 'items_in_set';
    public const INCLUDE_ITEM_ITEMSINSET_FIRSTKEY = '0';
    public const INCLUDE_ITEM_ITEMSINSET_FIRSTKEY_LANG_EN = 'en';
    public const INCLUDE_ITEM_ITEMSINSET_FIRSTKEY_LANG_EN_DESCRIPTION = 'description';

    public const MARKET_PLATINUM = 'platinum';
    public const MARKET_USER = 'user';
    public const MARKET_USER_INGAMENAME = 'ingame_name';
    public const MARKET_USER_STATUS = 'status';
    public const MARKET_USER_STATUS_ONLINE = 'online';
    public const MARKET_USER_STATUS_OFFLINE = 'offline';
}