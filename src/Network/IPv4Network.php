<?php

declare(strict_types=1);

namespace Littledev\IPTools\Network;

use Littledev\IPTools\Address\IPv4Address;
use Littledev\IPTools\Family\IPFamily;
use Littledev\IPTools\Helper\Prefix;
use Littledev\IPTools\Subnet\IPv4Subnet;

class IPv4Network extends AbstractIPNetwork
{
    public static function parse(string $cidr): self
    {
        $arr = explode('/', $cidr);

        $ip = IPv4Address::parse($arr[0]);
        $prefix = Prefix::prefixAsInt($arr[1] ?? null, IPFamily::v4()->maxPrefix());

        return new self(
            $ip,
            IPv4Subnet::fromPrefix($prefix)
        );
    }
}
