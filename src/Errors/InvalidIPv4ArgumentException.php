<?php


namespace Littledev\IPTools\Errors;


class InvalidIPv4ArgumentException extends InvalidIPArgumentException
{
    public static function address(string $address): self
    {
        return new self("Invalid IPv4 address: " . $address);
    }

    public static function invalidByteArray(array $array): self
    {
        return new self("Invalid byte array");
    }

    public static function binary(string $binaryString)
    {
        return new self("Invalid binary string, must be 32 long: " . $binaryString);
    }

}
