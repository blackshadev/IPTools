<?php

namespace Littledev\IPTools\Helper;

class ByteArray
{
    const BYTE_SIZE = 8;

    public static function isByteArray(array $arr)
    {
        return Arr::all($arr, fn ($i) => is_int($i) && $i >= 0 && $i <= 255);
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
