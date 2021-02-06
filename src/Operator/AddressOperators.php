<?php

declare(strict_types=1);

namespace Littledev\IPTools\Operator;

use Littledev\IPTools\Address;
use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\AddressableInterface;
use Littledev\IPTools\Helper\ByteArray;

class AddressOperators
{
    public static function nextIP(AddressableInterface $address): AddressInterface
    {
        $byteArray = $address->byteArray();
        $nextByteArray = ByteArray::addOne($byteArray);

        return Address::byteArray($nextByteArray);
    }
}
