<?php

namespace Littledev\IPTools\Helpers;

class ByteArray
{
    const BYTE_SIZE = 8;

    public static function fromBinaryString(string $binaryString): array
    {
        return array_map('bindec', str_split($binaryString, self::BYTE_SIZE));
    }

}
