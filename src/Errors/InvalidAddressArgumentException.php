<?php

declare(strict_types=1);

namespace Littledev\IPTools\Errors;

class InvalidAddressArgumentException extends InvalidArgumentException
{
    public static function invalidInput(string $cidr)
    {
        return new self('Invalid address given ' . $cidr);
    }
}
