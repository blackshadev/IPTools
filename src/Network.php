<?php

declare(strict_types=1);

namespace Littledev\IPTools;

use Littledev\IPTools\Error\InvalidNetworkArgumentException;
use Littledev\IPTools\Family\IPFamily;
use Littledev\IPTools\Family\IPFamilyInterface;
use Littledev\IPTools\Network\IPv4Network;
use Littledev\IPTools\Network\IPv6Network;
use Littledev\IPTools\Network\NetworkInterface;

final class Network
{
    public static function parse(string $cidr): NetworkInterface
    {
        $family = self::family($cidr);

        if ($family === IPFamily::v4()) {
            return self::ipv4($cidr);
        }

        if ($family === IPFamily::v6()) {
            return self::ipv6($cidr);
        }

        throw InvalidNetworkArgumentException::invalidInput($cidr);
    }

    public static function ipv4(string $address): NetworkInterface
    {
        return IPv4Network::parse($address);
    }

    public static function ipv6(string $address): NetworkInterface
    {
        return IPv6Network::parse($address);
    }

    public static function family(string $cidr): IPFamilyInterface
    {
        $arr = explode('/', $cidr);
        $ip = $arr[0];

        return Address::family($ip);
    }
}
