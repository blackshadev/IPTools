<?php

declare(strict_types=1);

namespace Littledev\IPTools\Subnet;

use Littledev\IPTools\Address\IPv6Address;
use Littledev\IPTools\Error\InvalidPrefixArgumentException;
use Littledev\IPTools\Family\IPFamily;
use Littledev\IPTools\Family\IPFamilyInterface;

class IPv6Subnet extends AbstractIPSubnet
{
    public static function fromPrefix(int $prefix): self
    {
        if ($prefix < 0 || $prefix > IPFamily::v6()->maxPrefix()) {
            throw InvalidPrefixArgumentException::invalidInput($prefix);
        }

        $binIP = str_repeat('1', $prefix) . str_repeat('0', IPFamily::v6()->maxPrefix() - $prefix);
        $subnet = IPv6Address::fromBinary($binIP);

        return new self($subnet, $prefix);
    }

    public function family(): IPFamilyInterface
    {
        return IPFamily::v6();
    }
}
