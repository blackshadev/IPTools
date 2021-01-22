<?php

use \PHPUnit\Framework\TestCase;
use Littledev\IPTools\Iterator\AddressIterator;
use Littledev\IPTools\Network;

class AddressIteratorTest extends TestCase
{
    public function testItWorks()
    {
        $network = Network::parse('127.0.0.1/24');
        $iter = new AddressIterator($network);

        foreach ($iter as $value) {

        }
    }
}
