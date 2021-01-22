<?php


namespace Littledev\IPTools\Helper;


use Littledev\IPTools\Error\InvalidPrefixArgumentException;

class Prefix
{
    public static function prefixAsInt(?string $prefix, int $max): int
    {
        if (is_string($prefix) && !preg_match('/^\d{1,3}$/', $prefix)) {
            throw InvalidPrefixArgumentException::invalidInput($prefix);
        }

        $int = $prefix != null ? ((int)$prefix) :  $max;
        if($int > $max) {
            throw InvalidPrefixArgumentException::size($prefix, $max);
        }

        return $int;
    }

}
