<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Littledev\IPTools\Errors\InvalidIPv4ArgumentException;
use Littledev\IPTools\IPv4Address;
use Littledev\IPTools\AddressInterface;
use Littledev\IPTools\IPv4Subnet;

class IPv4SubnetSpecTest extends TestCase
{
    public function testItWorks(): void
    {
        $sub = IPv4Subnet::fromPrefix(32);

        self::assertEquals(32, $sub->prefix());
        self::assertEquals('255.255.255.255', (string)$sub);
        self::assertEquals([255,255,255,255], $sub->byteArray());

        $sub = IPv4Subnet::fromPrefix(24);

        self::assertEquals(24, $sub->prefix());
        self::assertEquals('255.255.255.0', (string)$sub);
        self::assertEquals([255,255,255,0], $sub->byteArray());

        $sub = IPv4Subnet::fromPrefix(30);

        self::assertEquals(30, $sub->prefix());
        self::assertEquals('255.255.255.252', (string)$sub);
        self::assertEquals([255,255,255,252], $sub->byteArray());
    }
}
