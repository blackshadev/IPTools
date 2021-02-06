<?php

declare(strict_types=1);

use Littledev\IPTools\Error\InvalidPrefixArgumentException;

use Littledev\IPTools\Subnet\IPv6Subnet;
use PHPUnit\Framework\TestCase;

class IPv6SubnetSpecTest extends TestCase
{
    /**
     * @dataProvider validPrefixDataProvider
     */
    public function testItWorks($prefix, $string, $byteArray): void
    {
        $sub = IPv6Subnet::fromPrefix($prefix);

        self::assertEquals($prefix, $sub->prefix());
        self::assertEquals($string, (string)$sub);
        self::assertEquals($byteArray, $sub->byteArray());
    }

    public function testItErrorsOnToBigPrefix()
    {
        $this->expectException(InvalidPrefixArgumentException::class);
        IPv6Subnet::fromPrefix(129);
    }

    public function testItErrorsOnNegativePrefix()
    {
        $this->expectException(InvalidPrefixArgumentException::class);
        IPv6Subnet::fromPrefix(-1);
    }

    public function validPrefixDataProvider()
    {
        return [
            [
                128,
                'ffff:ffff:ffff:ffff:ffff:ffff:ffff:ffff',
                [255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255]
            ], [
                64,
                'ffff:ffff:ffff:ffff::',
                [255, 255, 255, 255, 255, 255, 255, 255, 0, 0, 0, 0, 0, 0, 0, 0  ]
            ], [
                42,
                    'ffff:ffff:ffc0::',
                [255, 255, 255, 255, 255, 192, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0  ]
            ], [
                109,
                'ffff:ffff:ffff:ffff:ffff:ffff:fff8:0',
                [255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 255, 248, 0, 0  ]
            ], [
                0,
                '::',
                [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0  ]
            ]
        ];
    }
}
