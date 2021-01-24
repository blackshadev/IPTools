<?php

declare(strict_types=1);


namespace Littledev\IPTools\Errors;

class InvalidPrefixArgumentException extends \InvalidArgumentException
{
    public static function invalidInput($prefix): self
    {
        return new self('Invalid prefix ' . $prefix);
    }

    public static function size($prefix, $max)
    {
        return new self('Prefix to big ' . $prefix . ' max allowed ' . $max);
    }
}
