<?php

declare(strict_types=1);


namespace Littledev\IPTools\Errors;

class InvalidPrefixArgumentException extends \InvalidArgumentException
{
    public const INVALID_INPUT = 'Invalid prefix %s';

    public const TOO_BIG = 'Prefix to big %d, while max allowed is %d';

    public static function invalidInput($prefix): self
    {
        return new self(sprintf('Invalid prefix %s', $prefix));
    }

    public static function tooBig($prefix, $max)
    {
        return new self(sprintf(self::TOO_BIG, $prefix, $max));
    }
}
