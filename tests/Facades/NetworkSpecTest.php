<?php

declare(strict_types=1);

use Littledev\IPTools\Error\InvalidIPv4ArgumentException;
use Littledev\IPTools\Error\InvalidIPv6ArgumentException;
use Littledev\IPTools\Error\InvalidNetworkArgumentException;
use Littledev\IPTools\IPFamily;
use Littledev\IPTools\Network;
use PHPUnit\Framework\TestCase;

class NetworkSpecTest extends TestCase
{
    /**
     * @dataProvider validIPv4Provider
     * @dataProvider validIPv6Provider
     */
    public function testItParsesValidInput($cidr, $prefix, $address, $family)
    {
        $ip = Network::parse($cidr);

        self::assertEquals($prefix, $ip->subnet()->prefix());
        self::assertEquals($address, (string)$ip->address());
        self::assertEquals($family, $ip->address()->version());
    }

    public function testItThrowsInGarbage()
    {
        $this->expectException(InvalidNetworkArgumentException::class);
        Network::parse('nope');
    }

    /**
     * @dataProvider validIPv4Provider
     */
    public function testItParsesIPv4Network($cidr, $prefix, $address)
    {
        $ip = Network::ipv4($cidr);

        self::assertEquals($prefix, $ip->subnet()->prefix());
        self::assertEquals($address, (string)$ip->address());
        self::assertEquals(IPFamily::IPv4, $ip->address()->version());
    }

    /**
     * @dataProvider validIPv6Provider
     */
    public function testItParsesIPv6Network($cidr, $prefix, $address)
    {
        $ip = Network::ipv6($cidr);

        self::assertEquals($prefix, $ip->subnet()->prefix());
        self::assertEquals($address, (string)$ip->address());
        self::assertEquals(IPFamily::IPv6, $ip->address()->version());
    }

    /**
     * @dataProvider validIPv6Provider
     */
    public function testIPv4ParserFailsOnIPv6($cidr)
    {
        $this->expectException(InvalidIPv4ArgumentException::class);
        Network::ipv4($cidr);
    }

    /**
     * @dataProvider validIPv4Provider
     */
    public function testIPv6ParserFailsOnIPv4($cidr)
    {
        $this->expectException(InvalidIPv6ArgumentException::class);
        Network::ipv6($cidr);
    }

    /**
     * @dataProvider validIPv4Provider
     * @dataProvider validIPv6Provider
     */
    public function testItDetectsIPv4Family($cidr, $_, $__, $expectedFamily)
    {
        $family = Network::family($cidr);
        self::assertEquals($expectedFamily, $family);
    }

    public function testItThrowsOnInvalidIP()
    {
        $family = Network::family('127.0.a.1/32');
        self::assertEquals(IPFamily::Invalid, $family);
    }

    public function validIPv4Provider(): Generator
    {
        yield ['127.0.0.1/24', 24, '127.0.0.1', IPFamily::IPv4];
        yield ['127.0.0.1', 32, '127.0.0.1', IPFamily::IPv4];
    }

    public function validIPv6Provider(): Generator
    {
        yield ['2001:db8::42/64', 64, '2001:db8::42', IPFamily::IPv6];
        yield ['2001:db8::42', 128, '2001:db8::42', IPFamily::IPv6];
    }
}
