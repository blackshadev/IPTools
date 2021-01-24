<?php

declare(strict_types=1);

use Littledev\IPTools\Error\InvalidPrefixArgumentException;
use Littledev\IPTools\Helper\Prefix;
use PHPUnit\Framework\TestCase;

class PrefixTest extends TestCase
{
    public function testItErrorsOnToBigPrefix()
    {
        $this->expectException(InvalidPrefixArgumentException::class);
        $this->expectDeprecationMessage(sprintf(InvalidPrefixArgumentException::TOO_BIG, 64, 32));
        Prefix::prefixAsInt("64", 32);
    }

    public function testItErrorsOnGarbagePrefix()
    {
        $this->expectException(InvalidPrefixArgumentException::class);
        $this->expectDeprecationMessage(sprintf(InvalidPrefixArgumentException::INVALID_INPUT, 'aa'));
        Prefix::prefixAsInt("aa", 32);
    }
}
