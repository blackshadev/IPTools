<?php

declare(strict_types=1);

use Littledev\IPTools\Iterator\AddressIterator;
use Littledev\IPTools\Network;
use Littledev\IPTools\Network\NetworkInterface;
use PHPUnit\Framework\TestCase;

class AddressIteratorTest extends TestCase
{
    /** @dataProvider dataProvider */
    public function testItIterates(NetworkInterface $network, int $count, string $firstIp, string $lastIp)
    {
        $iter = new AddressIterator($network);

        $array = iterator_to_array($iter, false);
        self::assertEquals($count, count($array));
        self::assertEquals($firstIp, (string)$array[0]);
        self::assertEquals($lastIp, (string)$array[count($array) - 1]);
    }

    public function dataProvider(): \Generator
    {
        yield [Network::parse('127.0.0.1/24'), 256, '127.0.0.0', '127.0.0.255'];
        yield [Network::parse('127.0.8.42/30'), 4, '127.0.8.40', '127.0.8.43'];
        yield [Network::parse('127.0.8.42/32'), 1, '127.0.8.42', '127.0.8.42'];

        yield [Network::parse('2001:db8::42/128'), 1, '2001:db8::42', '2001:db8::42'];
        yield [Network::parse('2001:db8::42/126'), 4, '2001:db8::40', '2001:db8::43'];
        yield [Network::parse('2001:db8::/120'), 256, '2001:db8::', '2001:db8::ff'];
    }
}
