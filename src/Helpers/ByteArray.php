<?php

declare(strict_types=1);

namespace Littledev\IPTools\Helpers;

class ByteArray
{
    public const BYTE_SIZE = 8;

    public static function fromBinaryString(string $binaryString): array
    {
        return array_map('bindec', mb_str_split($binaryString, self::BYTE_SIZE));
    }
}
