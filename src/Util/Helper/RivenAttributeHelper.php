<?php

namespace App\Util\Helper;

use App\UniqueNameInterface\WarframeApiInterface;
use App\Util\Helper\WarframeMarketApi;

class RivenAttributeHelper
{
    private array $attributesCurl = [];

    public function __construct (
        private WarframeMarketApi   $warframeMarketApi,
    ) {
        $this->attributesCurl = $this->warframeMarketApi->fetchRivenAttributes();
    }

    public function getRivenAttributeCurl (
        string $name
    ): ?string {
       foreach ($this->attributesCurl as $attribute) {
           if ($name === $attribute[WarframeApiInterface::ATTRIBUTES_EFFECT]) {

               return $attribute[WarframeApiInterface::ATTRIBUTES_URLNAME];
           }
       }

        return null;
    }

    public function getArrayIndexParent(
        array $array,
        string $name
    ): ?int {
        foreach($array as $key => $value){
            if(is_array($value) && $value[WarframeApiInterface::INCLUDE_ITEM][WarframeApiInterface::PAYLOAD_ATTRIBUTES] === $name)
                return $key;
        }
        return null;
    }

}
