<?php

declare(strict_types=1);

namespace Family;

use Littledev\IPTools\Family\IPFamily;
use PHPUnit\Framework\TestCase;

class FamilySpecTest extends TestCase
{
    public function test_ipv4_family(): void
    {
        $family = IPFamily::v4();

        self::assertEquals($family->maxPrefix(), 32);
        self::assertEquals($family->octets(), 4);
        self::assertEquals($family->name(), 'IPv4');
    }

    public function test_ipv6_family(): void
    {
        $family = IPFamily::v6();

        self::assertEquals($family->maxPrefix(), 128);
        self::assertEquals($family->octets(), 16);
        self::assertEquals($family->name(), 'IPv6');
    }

    public function test_invalid_family(): void
    {
        $family = IPFamily::invalid();

        self::assertEquals($family->maxPrefix(), 0);
        self::assertEquals($family->octets(), 0);
        self::assertEquals($family->name(), 'Invalid');
    }

    public function test_it_reuses_instances(): void
    {
        $v4 = IPFamily::v4();
        $v6 = IPFamily::v6();
        $invalid = IPFamily::invalid();

        self::assertSame($v4, IPFamily::v4());
        self::assertSame($v6, IPFamily::v6());
        self::assertSame($invalid, IPFamily::invalid());
    }
}
