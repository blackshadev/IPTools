<?php

declare(strict_types=1);

use Littledev\IPTools\Errors\InvalidPrefixArgumentException;

use Littledev\IPTools\Subnet\IPv4Subnet;
use PHPUnit\Framework\TestCase;

class IPv4SubnetSpecTest extends TestCase
{
    /**
     * @dataProvider validPrefixDataProvider
     */
    public function testItWorks($prefix, $string, $byteArray): void
    {
        $sub = IPv4Subnet::fromPrefix($prefix);

        self::assertEquals($prefix, $sub->prefix());
        self::assertEquals($string, (string)$sub);
        self::assertEquals($byteArray, $sub->byteArray());
    }

    public function testItErrorsOnToBigPrefix()
    {
        $this->expectException(InvalidPrefixArgumentException::class);
        IPv4Subnet::fromPrefix(33);
    }

    public function testItErrorsToNegativePrefix()
    {
        $this->expectException(InvalidPrefixArgumentException::class);
        IPv4Subnet::fromPrefix(-1);
    }

    public function validPrefixDataProvider()
    {
        return [
            [32, '255.255.255.255', [255, 255, 255, 255]],
            [24, '255.255.255.0', [255, 255, 255, 0  ]],
            [0, '0.0.0.0', [0, 0, 0, 0  ]],
            [30, '255.255.255.252', [255, 255, 255, 252]],
        ];
    }
}
