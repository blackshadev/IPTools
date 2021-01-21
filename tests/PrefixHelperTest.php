<?php

use \PHPUnit\Framework\TestCase;
use \Littledev\IPTools\Errors\InvalidPrefixArgumentException;
use \Littledev\IPTools\Helpers\Prefix;

class PrefixHelperTest extends TestCase
{

    public function testItErrorsOnToBigPrefix() {
        $this->expectException(InvalidPrefixArgumentException::class);
        Prefix::prefixAsInt("64", 32);
    }

    public function testItErrorsOnGarbagePrefix() {
        $this->expectException(InvalidPrefixArgumentException::class);
        Prefix::prefixAsInt("aa", 32);
    }
}
