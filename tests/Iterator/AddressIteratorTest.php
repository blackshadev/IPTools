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

        $array = iterator_to_array($iter, false);
        self::assertEquals(256, count($array));
        self::assertEquals($network->getFirstIP(), $array[0]);
        self::assertEquals($network->getLastIP(), $array[count($array) - 1]);

        $network = Network::parse('127.0.8.42/30');
        $iter = new AddressIterator($network);

        $array = iterator_to_array($iter, false);
        self::assertEquals(4, count($array));
        self::assertEquals($network->getFirstIP(), $array[0]);
        self::assertEquals($network->getLastIP(), $array[count($array) - 1]);
    }
}
