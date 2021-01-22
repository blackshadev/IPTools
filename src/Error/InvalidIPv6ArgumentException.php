<?php


namespace Littledev\IPTools\Error;


use Littledev\IPTools\IPFamily;

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

    public static function invalidByteArray(array $byteArray)
    {
        return new self(sprintf("Invalid byte array, it must be %d long, got %d", IPFamily::OCTET_IPv6, count($byteArray)));
    }
}
