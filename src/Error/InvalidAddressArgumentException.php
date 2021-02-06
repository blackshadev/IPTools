<?php

declare(strict_types=1);

namespace Littledev\IPTools\Error;

use Littledev\IPTools\Family\IPFamily;

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
                IPFamily::v4()->octets(),
                IPFamily::v6()->octets(),
                count($byteArray)
            )
        );
    }

    public static function invalidInAddr(string $inAddr)
    {
        return new self(
            sprintf(
                'Invalid InAddr. Expected length %d or %d, got %d',
                IPFamily::v4()->octets(),
                IPFamily::v6()->octets(),
                mb_strlen($inAddr)
            )
        );
    }
}
