<?php

declare(strict_types=1);

namespace Littledev\IPTools;

use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Address\IPv4Address;
use Littledev\IPTools\Address\IPv6Address;
use Littledev\IPTools\Error\InvalidAddressArgumentException;
use Littledev\IPTools\Family\IPFamily;
use Littledev\IPTools\Family\IPFamilyInterface;

final class Address
{
    public static function parse(string $ip): AddressInterface
    {
        $family = self::family($ip);

        if ($family === IPFamily::v4()) {
            return self::ipv4($ip);
        }

        if ($family === IPFamily::v6()) {
            return self::ipv6($ip);
        }

        throw InvalidAddressArgumentException::address($ip);
    }

    public static function byteArray(array $byteArray): AddressInterface
    {
        if (count($byteArray) <= IPFamily::v4()->octets()) {
            return IPv4Address::fromByteArray($byteArray);
        }

        if (count($byteArray) <= IPFamily::v6()->octets()) {
            return IPv6Address::fromByteArray($byteArray);
        }

        throw InvalidAddressArgumentException::invalidByteArrayLength($byteArray);
    }

    public static function ipv4(string $address): AddressInterface
    {
        return IPv4Address::parse($address);
    }

    public static function ipv6(string $address): AddressInterface
    {
        return IPv6Address::parse($address);
    }

    public static function family(string $ip): IPFamilyInterface
    {
        if (IPv6Address::isValid($ip)) {
            return IPFamily::v6();
        }

        if (IPv4Address::isValid($ip)) {
            return IPFamily::v4();
        }

        return IPFamily::invalid();
    }

    public static function fromInAddr(string $inAddr)
    {
        if (mb_strlen($inAddr) === IPFamily::v4()->octets()) {
            return IPv4Address::fromInAddr($inAddr);
        }

        if (mb_strlen($inAddr) === IPFamily::v6()->octets()) {
            return IPv6Address::fromInAddr($inAddr);
        }

        throw InvalidAddressArgumentException::invalidInAddr($inAddr);
    }
}
