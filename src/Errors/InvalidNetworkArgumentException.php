<?php

declare(strict_types=1);

namespace Littledev\IPTools\Errors;

class InvalidNetworkArgumentException extends InvalidArgumentException
{
    public static function invalidInput(string $cidr)
    {
        return new self('Invalid CIDR given ' . $cidr);
    }
}
