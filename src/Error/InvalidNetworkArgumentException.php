<?php

namespace Littledev\IPTools\Error;

class InvalidNetworkArgumentException extends InvalidArgumentException
{
    public static function invalidInput(string $cidr)
    {
        return new self('Invalid CIDR given ' . $cidr);
    }

}
