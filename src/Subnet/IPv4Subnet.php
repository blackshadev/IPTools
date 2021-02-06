<?php

declare(strict_types=1);

namespace Littledev\IPTools\Subnet;

use Littledev\IPTools\Address\IPv4Address;
use Littledev\IPTools\Error\InvalidPrefixArgumentException;
use Littledev\IPTools\Family\IPFamily;
use Littledev\IPTools\Family\IPFamilyInterface;

class IPv4Subnet extends AbstractIPSubnet
{
    public static function fromPrefix(int $prefix): self
    {
        if ($prefix < 0 || $prefix > IPFamily::v4()->maxPrefix()) {
            throw InvalidPrefixArgumentException::invalidInput($prefix);
        }

        $binIP = str_repeat('1', $prefix) . str_repeat('0', IPFamily::v4()->maxPrefix() - $prefix);
        $subnet = IPv4Address::fromBinary($binIP);

        return new self($subnet, $prefix);
    }

    public function family(): IPFamilyInterface
    {
        return IPFamily::v4();
    }
}
