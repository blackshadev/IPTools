<?php

declare(strict_types=1);

namespace Littledev\IPTools\Error;

class InvalidNetworkArgumentException extends InvalidArgumentException
{
    public static function invalidInput(string $cidr)
    {
        return new self('Invalid CIDR given ' . $cidr);
    }
}
