<?php

declare(strict_types=1);

namespace Littledev\IPTools\Helper;

use Littledev\IPTools\Error\InvalidPrefixArgumentException;

class Prefix
{
    public static function prefixAsInt(?string $prefix, int $max): int
    {
        if (is_string($prefix) && !preg_match('/^\d+$/', $prefix)) {
            throw InvalidPrefixArgumentException::invalidInput($prefix);
        }

        $int = $prefix !== null ? $prefix : $max;
        if ($int > $max) {
            throw InvalidPrefixArgumentException::tooBig($prefix, $max);
        }

        return (int)$int;
    }
}
