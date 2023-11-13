<?php

declare(strict_types=1);

namespace App\UniqueNameInterface;

class ItemInterface
{
    public const FORM_NAME = 'name';
    public const FORM_PRICE = 'price';
    public const FORM_PLATFORMID = 'platformId';
    public const FORM_TYPE = 'type';
    public const FORM_ID = 'id';

    public const ENTITY_NAME = 'name';
    public const ENTITY_NAMECURL = 'nameCurl';
    public const ENTITY_LOGINID = 'login_id';
    public const ENTITY_PRICE = 'price';
    public const ENTITY_PLATFORMID = 'platform_id';

    public const ITEM_NAME_PRIME = 'prime';
    public const ITEM_TYPE_WARFRAME = 'warframe';
    public const ITEM_TYPE_WEAPON = 'weapon';
    public const ITEM_TYPE_MOD = 'mod';
    public const ITEM_TYPE_ITEM = 'item';
}