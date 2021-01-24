<?php

declare(strict_types=1);

namespace Littledev\IPTools;

use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Address\IPv4Address;
use Littledev\IPTools\Address\IPv6Address;
use Littledev\IPTools\Errors\InvalidAddressArgumentException;

final class Address
{
    public static function parse(string $ip): AddressInterface
    {
        $family = self::family($ip);

        if ($family === IPFamily::IPv4) {
            return self::ipv4($ip);
        }

        if ($family === IPFamily::IPv6) {
            return self::ipv6($ip);
        }

        throw InvalidAddressArgumentException::invalidInput($ip);
    }

    public static function ipv4(string $address): AddressInterface
    {
        return IPv4Address::parse($address);
    }

    public static function ipv6(string $address): AddressInterface
    {
        return IPv6Address::parse($address);
    }

    public static function family(string $ip): string
    {
        if (IPv6Address::isValid($ip)) {
            return IPFamily::IPv6;
        }

        if (IPv4Address::isValid($ip)) {
            return IPFamily::IPv4;
        }

        return IPFamily::Invalid;
    }
}
