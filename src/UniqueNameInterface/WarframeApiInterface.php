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

    public const MARKET_PLATINUM = 'platinum';
    public const MARKET_USER = 'user';
    public const MARKET_USER_INGAMENAME = 'ingame_name';
    public const MARKET_USER_STATUS = 'status';
    public const MARKET_USER_STATUS_ONLINE = 'online';
    public const MARKET_USER_STATUS_OFFLINE = 'offline';
}