<?php

declare(strict_types=1);

namespace Littledev\IPTools\Operator;

use Littledev\IPTools\Address;
use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\AddressableInterface;

class NetworkOperators
{
    public static function firstIP(AddressableInterface $address): AddressInterface
    {
        return Address::fromInAddr($address->address()->inAddr() & $address->subnet()->inAddr());
    }

    public static function lastIP(AddressableInterface $address): AddressInterface
    {
        return Address::fromInAddr(self::firstIP($address)->inAddr() | ~$address->subnet()->inAddr());
    }

    public static function contains(AddressableInterface $network, AddressableInterface $address): bool
    {
        $firstIp = NetworkOperators::firstIP($network);
        $lastIp = NetworkOperators::lastIP($network);

        return (strcmp($address->address()->inAddr(), $firstIp->inAddr()) >= 0)
            && (strcmp($address->address()->inAddr(), $lastIp->inAddr()) <= 0)
            && $network->subnet()->prefix() <= $address->subnet()->prefix();
    }
}
