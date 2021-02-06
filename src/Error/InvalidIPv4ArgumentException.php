<?php

declare(strict_types=1);

namespace Littledev\IPTools\Error;

use Littledev\IPTools\Family\IPFamily;

class InvalidIPv4ArgumentException extends InvalidArgumentException
{
    public const ADDRESS = 'Invalid IPv4 address %s';

    public const BINARY = 'Invalid binary string, %s';

    public const BYTE_ARRAY = 'Invalid byte array, it must be %d long, got %d';

    public static function address(string $address): self
    {
        return new self(sprintf(self::ADDRESS, $address));
    }

    public static function invalidByteArray(array $byteArray): self
    {
        return new self(sprintf(self::BYTE_ARRAY, IPFamily::v4()->octets(), count($byteArray)));
    }

    public static function binary(string $binaryString): self
    {
        return new self(sprintf(self::BINARY, $binaryString));
    }
}
