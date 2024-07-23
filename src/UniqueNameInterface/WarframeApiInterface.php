<?php

declare(strict_types=1);

namespace App\UniqueNameInterface;

class WarframeApiInterface
{
    public const URL = 'https://api.warframe.market/v1/';
    public const URL_ITEMS = 'items/';
    public const URL_ORDER = '/orders?include=item';
    public const URL_AUCTION = 'auctions/search?type=riven&sort_by=price_asc&weapon_url_name=';
    public const URL_ATTRIBUTES = 'riven/attributes';

    public const FETCHED_PAYLOAD = 'payload';
    public const PAYLOAD_ORDERS = 'orders';
    public const PAYLOAD_INCLUDE = 'include';
    public const PAYLOAD_AUCTIONS = 'auctions';
    public const PAYLOAD_ATTRIBUTES = 'attributes';
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

    public const AUCTION_BUYOUT = 'buyout_price';
    public const AUCTION_ITEM = 'item';
    public const AUCTION_ITEM_ATTRIBUTES = 'attributes';

    public const ATTRIBUTES_POSITIVE = 'positive';
    public const ATTRIBUTES_EFFECT = 'effect';
    public const ATTRIBUTES_URLNAME = 'url_name';
}
