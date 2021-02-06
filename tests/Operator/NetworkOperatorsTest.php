<?php

declare(strict_types=1);

use Littledev\IPTools\Address;
use Littledev\IPTools\AddressableInterface;
use Littledev\IPTools\Network;
use Littledev\IPTools\Operator\NetworkOperators;
use PHPUnit\Framework\TestCase;

class NetworkOperatorsTest extends TestCase
{
    /**
     * @dataProvider networkIPProvider
     */
    public function testItGetsFirstIpFromNetwork(AddressableInterface $address, string $firstIP, string $lastIP)
    {
        $result = NetworkOperators::firstIP($address);
        self::assertEquals($firstIP, $result);
        self::assertSame($address->address()->family(), $result->family());
    }

    /**
     * @dataProvider networkIPProvider
     */
    public function testItGetsLastIpFromNetwork(AddressableInterface $address, string $firstIP, string $lastIP)
    {
        $result = NetworkOperators::lastIP($address);
        self::assertEquals($lastIP, $result);
        self::assertSame($address->address()->family(), $result->family());
    }

    /**
     * @dataProvider networkContainsProvider
     */
    public function testItContains(AddressableInterface $network, array $inNetwork, array $outNetwork)
    {
        foreach ($inNetwork as $address) {
            self::assertTrue(NetworkOperators::contains($network, Address::parse($address)));
        }

        foreach ($outNetwork as $address) {
            self::assertFalse(NetworkOperators::contains($network, Address::parse($address)));
        }
    }

    public function networkContainsProvider(): \Generator
    {
        yield [
            Network::ipv4('127.0.0.1/24'),
            ['127.0.0.4', '127.0.0.9'],
            ['127.0.1.1', '8.8.8.8', '2001:db8::', '::127.0.0.1'],
        ];
        yield [
            Network::ipv6('2001:db8::/64'),
            ['2001:db8::1', '2001:db8::ff'],
            ['2001:db8:1::', '8.8.8.8'],
        ];
    }

    public function networkIPProvider(): \Generator
    {
        yield [Network::ipv4('127.0.0.1/24'), '127.0.0.0', '127.0.0.255'];
        yield [Network::ipv4('127.0.0.42/32'), '127.0.0.42', '127.0.0.42'];
        yield [Network::ipv4('127.0.0.42/31'), '127.0.0.42', '127.0.0.43'];
        yield [Network::ipv4('127.0.0.43/31'), '127.0.0.42', '127.0.0.43'];
        yield [Network::ipv4('127.0.0.43/16'), '127.0.0.0', '127.0.255.255'];

        yield [Network::ipv6('2001:db8::/112'), '2001:db8::', '2001:db8::ffff'];
        yield [Network::ipv6('2001:db8::42/128'), '2001:db8::42', '2001:db8::42'];
        yield [Network::ipv6('2001:db8::42/127'), '2001:db8::42', '2001:db8::43'];
        yield [Network::ipv6('2001:db8::43/127'), '2001:db8::42', '2001:db8::43'];
        yield [Network::ipv6('2001:db8::/64'), '2001:db8::', '2001:db8::ffff:ffff:ffff:ffff'];

        yield [Address::ipv4('127.0.0.42'), '127.0.0.42', '127.0.0.42'];
        yield [Address::ipv6('2001:db8::42'), '2001:db8::42', '2001:db8::42'];
    }
}
