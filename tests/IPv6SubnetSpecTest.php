<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Littledev\IPTools\Subnet\IPv6Subnet;

class IPv6SubnetSpecTest extends TestCase
{
    public function testItWorks(): void
    {
        $sub = IPv6Subnet::fromPrefix(64);

        self::assertEquals(64, $sub->prefix());
        self::assertEquals('ffff:ffff:ffff:ffff::', (string)$sub);
        self::assertEquals([255,255,255,255,255,255,255,255,0,0,0,0,0,0,0,0], $sub->byteArray());

    }
}
