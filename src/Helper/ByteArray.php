<?php

declare(strict_types=1);

namespace Littledev\IPTools\Helper;

class ByteArray
{
    public const BYTE_SIZE = 8;

    public static function isByteArray(array $arr)
    {
        return Arr::all($arr, function ($i) {return is_int($i) && $i >= 0 && $i <= 255;});
    }

    public static function fromInAddr(string $inAddr): array
    {
        return array_values(unpack('C*', $inAddr));
    }

    public static function toInAddr(array $byteArray): string
    {
        $inAddr = '';
        foreach ($byteArray as $char) {
            $inAddr .= pack('C*', $char);
        }

        return $inAddr;
    }

    public static function fromBinaryString(string $binaryString): array
    {
        return array_map('bindec', str_split($binaryString, self::BYTE_SIZE));
    }

    public static function addOne(array $byteArray): array
    {
        for ($byteIndex = count($byteArray) - 1; $byteIndex >= 0; $byteIndex--) {
            if ($byteArray[$byteIndex] < 255) {
                $byteArray[$byteIndex]++;
                break;
            }

            $byteArray[$byteIndex] = 0;
        }

        return $byteArray;
    }
}
