<?php

declare(strict_types=1);


namespace Littledev\IPTools\Network;

use Littledev\IPTools\Address\IPv6Address;
use Littledev\IPTools\Family\IPFamily;
use Littledev\IPTools\Helper\Prefix;
use Littledev\IPTools\Subnet\IPv6Subnet;

class IPv6Network extends AbstractIPNetwork
{
    public static function parse(string $cidr): self
    {
        $arr = explode('/', $cidr);

        $ip = IPv6Address::parse($arr[0]);
        $prefix = Prefix::prefixAsInt($arr[1] ?? null, IPFamily::v6()->maxPrefix());

        return new self(
            $ip,
            IPv6Subnet::fromPrefix($prefix)
        );
    }
}
