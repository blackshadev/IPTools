<?php


namespace Littledev\IPTools\Errors;


class InvalidIPv6ArgumentException extends InvalidArgumentException
{
    public static function address(string $address)
    {
        return new self("Invalid IPv6 address given " . $address);
    }

    public static function binary(string $binary)
    {
        return new self("Invalid binary address, must be 64 long " . $binary);
    }
}
