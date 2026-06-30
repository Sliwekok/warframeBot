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
    public const FORM_ISRIVEN = 'isRiven';
    public const FORM_ITEMID = 'item_id';

    public const ENTITY_NAME = 'name';
    public const ENTITY_NAMECURL = 'nameCurl';
    public const ENTITY_LOGINID = 'login_id';
    public const ENTITY_PRICE = 'price';
    public const ENTITY_PLATFORMID = 'platform_id';
    public const ENTITY_ID = 'id';
    public const ENTITY_ITEM_ID = 'item';
    public const ENTITY_SLUG = 'slug';

    public const ITEM_NAME_PRIME = 'prime';
    public const ITEM_TYPE_WARFRAME = 'warframe';
    public const ITEM_TYPE_WEAPON = 'weapon';
    public const ITEM_TYPE_MOD = 'mod';
    public const ITEM_TYPE_ITEM = 'item';
    public const ITEM_STATUS = 'status';
    public const ITEM_STATUS_PLACED = 'placed';
    public const ITEM_STATUS_WAITING = 'waiting';
    public const ITEM_STATUS_CANCELED = 'canceled';
    public const ITEM_STATUS_FINISHED = 'finished';

    public const FORM_RIVEN_ATTR = 'attributes';
    public const FORM_RIVEN_ATTR_POSITIVE_1 = 'attrPositive1';
    public const FORM_RIVEN_ATTR_POSITIVE_2 = 'attrPositive2';
    public const FORM_RIVEN_ATTR_POSITIVE_3 = 'attrPositive3';
    public const FORM_RIVEN_ATTR_NEGATIVE = 'attrNegative';
    public const ITEM_TYPE_WARFRAME_MOD = 'Warframe Mod';
    public const ITEM_FOUNDRY = 'foundry';
}
