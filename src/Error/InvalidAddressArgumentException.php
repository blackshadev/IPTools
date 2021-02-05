<?php

declare(strict_types=1);

namespace Littledev\IPTools\Error;

use Littledev\IPTools\IPFamily;

class InvalidAddressArgumentException extends InvalidArgumentException
{
    public static function address(string $cidr)
    {
        return new self('Invalid address given ' . $cidr);
    }

    public static function invalidByteArrayLength(array $byteArray)
    {
        return new self(
            sprintf(
                'Invalid byteArray length given. Expected %d or %d, got %d',
                IPFamily::OCTET_IPv4,
                IPFamily::OCTET_IPv6,
                count($byteArray)
            )
        );
    }
}
