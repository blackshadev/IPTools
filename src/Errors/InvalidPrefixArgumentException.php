<?php


namespace Littledev\IPTools\Errors;

class InvalidPrefixArgumentException extends \InvalidArgumentException
{
    public static function invalidInput(string $prefix): self
    {
        return new self('Invalid prefix ' . $prefix);
    }

    public static function size(int $prefix, int $max)
    {
        return new self('Prefix to big ' . $prefix . ' max allowed ' . $max );
    }
}
