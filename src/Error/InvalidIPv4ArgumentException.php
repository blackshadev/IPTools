<?php


namespace Littledev\IPTools\Error;


use Littledev\IPTools\IPFamily;

class InvalidIPv4ArgumentException extends InvalidArgumentException
{
    public static function address(string $address): self
    {
        return new self("Invalid IPv4 address: " . $address);
    }

    public static function invalidByteArray(array $byteArray)
    {
        return new self(sprintf("Invalid byte array, it must be %d long, got %d", IPFamily::OCTET_IPv4, count($byteArray)));
    }

    public static function binary(string $binaryString)
    {
        return new self("Invalid binary string, must be 32 long: " . $binaryString);
    }

}
