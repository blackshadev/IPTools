<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Littledev\IPTools\Network\IPv4Network;
use Littledev\IPTools\Address\IPv4Address;
use Littledev\IPTools\Address\IPv6Address;
use Littledev\IPTools\Errors\InvalidPrefixArgumentException;

class IPv4NetworkSpecTest extends TestCase
{
    public function testItParsesNetwork(): void
    {
        $network = IPv4Network::parse('127.0.0.1/24');

        self::assertEquals('127.0.0.1', $network->address());
        self::assertEquals(24, $network->subnet()->prefix());

        self::assertEquals('127.0.0.0', $network->getFirstIP());
        self::assertEquals('127.0.0.255', $network->getLastIP());
    }

    public function testContainsWorksWithAFullSubnet(): void
    {
        $network = IPv4Network::parse('127.0.0.1/24');

        self::assertTrue($network->contains(IPv4Address::parse('127.0.0.1')));
        self::assertTrue($network->contains(IPv4Address::parse('127.0.0.127')));
        self::assertFalse($network->contains(IPv4Address::parse('127.0.1.0')));

        self::assertFalse($network->contains(IPv4Address::parse('8.8.8.8')));
    }

    public function testContainsWorksWithAHalfSubnet(): void
    {
        $network = IPv4Network::parse('8.8.8.8/20');

        self::assertTrue($network->contains(IPv4Address::parse('8.8.0.0')));
        self::assertTrue($network->contains(IPv4Address::parse('8.8.8.128')));
        self::assertTrue($network->contains(IPv4Address::parse('8.8.11.128')));
        self::assertTrue($network->contains(IPv4Address::parse('8.8.15.254')));

        self::assertFalse($network->contains(IPv4Address::parse('127.0.1.0')));
    }

    public function testContainsWorksWithIPv6(): void
    {

        $network = IPv4Network::parse('8.8.8.8/24');

        self::assertFalse($network->contains(IPv6Address::parse('::808:808')));
        self::assertFalse($network->contains(IPv6Address::parse('::ffff:808:808')));
    }

    public function testContainsWorksWithNetworkInNetwork(): void
    {
        $network = IPv4Network::parse('127.0.0.1/16');

        self::assertTrue($network->contains(IPv4Network::parse('127.0.0.1/16')));
        self::assertTrue($network->contains(IPv4Network::parse('127.0.1.1/24')));
        self::assertTrue($network->contains(IPv4Network::parse('127.0.0.4/23')));

        self::assertFalse($network->contains(IPv4Network::parse('172.16.0.1/16')));
    }

    public function testItDefaultsPrefixTo32(): void
    {
        $network = IPv4Network::parse('127.0.0.1');

        self::assertEquals(32, $network->subnet()->prefix());
    }

    public function testItThrowsOnInvalidPrefix(): void
    {
        $this->expectException(InvalidPrefixArgumentException::class);
        IPv4Network::parse('127.0.0.1/ab');
    }

    public function testItThrowsOnTooBigPrefix(): void
    {
        $this->expectException(InvalidPrefixArgumentException::class);
        IPv4Network::parse('127.0.0.1/64');
    }

    public function testItCalculatesFirstAndLastIPs(): void
    {
        $net = IPv4Network::parse('127.0.0.1/24');
        self::assertEquals('127.0.0.0', (string)$net->getFirstIP());
        self::assertEquals('127.0.0.255', (string)$net->getLastIP());

        $net = IPv4Network::parse('127.0.0.30/30');
        self::assertEquals('127.0.0.28', (string)$net->getFirstIP());
        self::assertEquals('127.0.0.31', (string)$net->getLastIP());
    }
}
