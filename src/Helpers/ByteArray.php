<?php

declare(strict_types=1);

namespace Littledev\IPTools\Helpers;

class ByteArray
{
    public const BYTE_SIZE = 8;

    public static function isByteArray(array $arr)
    {
        return Arr::any($arr, fn ($i) => !is_int($i) || $i < 0 || $i > 255);
    }

    public static function fromPrefix(int $size, int $prefix): array
    {
        $arr = array_fill(0, $size, 0);
        for ($iX = 0; $iX < $size && $prefix > 0; $iX++) {
            $bitsToSet = min($prefix, self::BYTE_SIZE);
            $prefix -= $bitsToSet;

            $binaryValue = str_repeat('1', $bitsToSet) . str_repeat('0', self::BYTE_SIZE - $bitsToSet);
            $arr[$iX] = bindec($binaryValue);
        }

        return $arr;
    }

    public static function fromBinaryString(string $binaryString): array
    {
        return array_map('bindec', mb_str_split($binaryString, self::BYTE_SIZE));
    }
}
