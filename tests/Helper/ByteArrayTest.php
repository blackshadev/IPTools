<?php

declare(strict_types=1);

use Littledev\IPTools\Helper\ByteArray;
use PHPUnit\Framework\TestCase;

class ByteArrayTest extends TestCase
{
    /**
     * @dataProvider validAddOneProvider
     */
    public function testItAddsOne($input, $expected)
    {
        $output = ByteArray::addOne($input);
        self::assertEquals($expected, $output);
    }

    /**
     * @dataProvider validInAddrProvider
     */
    public function testItConvertsFromInAddr($inAddr, $expected)
    {
        $byteArray = ByteArray::fromInAddr(inet_pton($inAddr));
        self::assertEquals($expected, $byteArray);
    }

    public function validInAddrProvider(): Generator
    {
        yield ['0.0.0.0', [0, 0, 0, 0]];
        yield ['127.0.0.1', [127, 0, 0, 1]];
    }

    public function validAddOneProvider(): Generator
    {
        yield [ [], [] ];
        yield [ [127, 0, 0, 1], [127, 0, 0, 2] ];
        yield [ [1], [2] ];
        yield [ [127, 0, 0, 255], [127, 0, 1, 0] ];
    }
}
