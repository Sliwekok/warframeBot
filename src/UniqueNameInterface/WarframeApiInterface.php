<?php

declare(strict_types=1);

namespace App\UniqueNameInterface;

class WarframeApiInterface
{
    public const URL = 'https://api.warframe.market/v2/';
    public const URL_ASSETS = 'https://warframe.market/static/assets/';
    public const URL_ITEM = 'item/';
    public const URL_ITEMS = 'items';
    public const URL_ORDER = '/orders?include=item';
    public const URL_ITEM_ORDER = 'orders/item/';
    public const URL_AUCTION = 'auctions/search?type=riven&sort_by=price_asc&weapon_url_name=';
    public const URL_ATTRIBUTES = 'riven/attributes';

    public const FETCHED_PAYLOAD = 'payload';
    public const PAYLOAD_ORDERS = 'orders';
    public const PAYLOAD_INCLUDE = 'include';
    public const PAYLOAD_AUCTIONS = 'auctions';
    public const PAYLOAD_ATTRIBUTES = 'attributes';
    public const INCLUDE_ITEM = 'item';
    public const INCLUDE_ITEM_ORDERTYPE_BUY = 'buy';
    public const INCLUDE_ITEM_ITEMSINSET_TAGS = 'tags';

    public const MARKET_PLATINUM = 'platinum';
    public const MARKET_USER = 'user';
    public const MARKET_USER_INGAMENAME = 'ingame_name';
    public const MARKET_USER_STATUS = 'status';
    public const MARKET_USER_VISISBLE = 'visible';

    public const AUCTION_BUYOUT = 'buyout_price';
    public const AUCTION_ITEM = 'item';
    public const AUCTION_ITEM_ATTRIBUTES = 'attributes';

    public const ATTRIBUTES_POSITIVE = 'positive';
    public const ATTRIBUTES_EFFECT = 'effect';
    public const ATTRIBUTES_URLNAME = 'url_name';
    public const DATA = 'data';
    public const ITEM_TYPE = 'type';
    public const ITEM_I18 = 'i18n';
    public const ITEM_EN = 'en';
    public const ITEM_WIKI_LINK = 'wikiLink';
    public const ITEM_SLUG = 'slug';
    public const ITEM_TRADABLE = 'tradable';
    public const ITEM_NAME = 'name';
    public const ITEM_VAULTED = 'vaulted';
    public const ITEM_ID = 'id';
    public const ITEM_ICON = 'icon';
    public const ITEM_DESCRIPTION = 'description';
    public const ITEM_SELLTYPE = 'type';
    public const ITEM_SELLTYPE_BUY = 'buy';
    public const ITEM_SELLTYPE_SELL = 'sell';
}
