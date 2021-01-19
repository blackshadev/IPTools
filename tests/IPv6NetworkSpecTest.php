<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Littledev\IPTools\Network\IPv6Network;
use Littledev\IPTools\Address\IPv4Address;
use Littledev\IPTools\Address\IPv6Address;
use Littledev\IPTools\Errors\InvalidPrefixArgumentException;

class IPv6NetworkSpecTest extends TestCase
{
    public function testItParsesNetwork(): void
    {
        $network = IPv6Network::parse('2001:db8::/64');

        self::assertEquals('2001:db8::', (string)$network->address());
        self::assertEquals(64, $network->subnet()->prefix());

        self::assertEquals('2001:db8::', $network->getFirstIP());
        self::assertEquals('2001:db8::ffff:ffff:ffff:ffff', $network->getLastIP());
    }

    public function testContainsWorksWithANormalSubnet(): void
    {
        $network = IPv6Network::parse('2001:db8::/64');

        self::assertTrue($network->contains(IPv6Address::parse('2001:db8::')));
        self::assertTrue($network->contains(IPv6Address::parse('2001:db8::ffff:ffff:ffff:ffff')));
        self::assertTrue($network->contains(IPv6Address::parse('2001:db8::ce1:42')));

        self::assertFalse($network->contains(IPv6Address::parse('2001:db8:d1::')));
        self::assertFalse($network->contains(IPv6Address::parse('2001:4860:4860::8844')));
    }
    public function testContainsWorksWithAFullSubnet(): void
    {
        $network = IPv6Network::parse('2001:db8::42/128');

        self::assertTrue($network->contains(IPv6Address::parse('2001:db8::42')));

        self::assertFalse($network->contains(IPv6Address::parse('2001:db8::1')));
        self::assertFalse($network->contains(IPv6Address::parse('2001:db8:db1::')));
    }

    public function testContainsWorksWithAPartialSubnet(): void
    {
        $network = IPv6Network::parse('2001:db8::42/122');

        self::assertTrue($network->contains(IPv6Address::parse('2001:db8::40')));
        self::assertTrue($network->contains(IPv6Address::parse('2001:db8::7f')));
        self::assertTrue($network->contains(IPv6Address::parse('2001:db8::55')));

        self::assertFalse($network->contains(IPv6Address::parse('2001:db8::ff')));
        self::assertFalse($network->contains(IPv6Address::parse('2001:db8::00')));
        self::assertFalse($network->contains(IPv6Address::parse('2001:4860:4860::8844')));
    }

    public function testContainsWorksWithIPv4(): void
    {
        $network = IPv6Network::parse('::808:808/64');
        self::assertFalse($network->contains(IPv4Address::parse('8.8.8.8')));
        self::assertFalse($network->contains(IPv4Address::parse('127.0.0.1')));
    }

    public function testContainsWorksWithNetworkInNetwork(): void
    {
        $network = IPv6Network::parse('2001:db8::/64');

        self::assertTrue($network->contains(IPv6Network::parse('2001:db8::/64')));
        self::assertTrue($network->contains(IPv6Network::parse('2001:db8::42/122')));
        self::assertTrue($network->contains(IPv6Network::parse('2001:db8::43/128')));
//
        self::assertFalse($network->contains(IPv6Network::parse('2001:db9::/64')));
        self::assertFalse($network->contains(IPv6Network::parse('2001:db8::/48')));
    }

    public function testItDefaultsPrefixTo32(): void
    {
        $network = IPv6Network::parse('2001:db8::42');

        self::assertEquals(128, $network->subnet()->prefix());
    }

    public function testItThrowsOnInvalidPrefix(): void
    {
        $this->expectException(InvalidPrefixArgumentException::class);
        IPv6Network::parse('2001:db8::/ab');
    }

    public function testItThrowsOnTooBigPrefix(): void
    {
        $this->expectException(InvalidPrefixArgumentException::class);
        IPv6Network::parse('2001:db8::/130');
    }

}
