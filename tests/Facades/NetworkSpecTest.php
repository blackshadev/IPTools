<?php

use PHPUnit\Framework\TestCase;
use Littledev\IPTools\Network;
use Littledev\IPTools\IPFamily;
use Littledev\IPTools\Error\InvalidNetworkArgumentException;

class NetworkSpecTest extends TestCase
{
    /**
     * @dataProvider validIPsProviders
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

    public function validIPsProviders(): Generator
    {
        yield ['2001:db8::42/64', 64, '2001:db8::42', IPFamily::IPv6];
        yield ['2001:db8::42', 128, '2001:db8::42', IPFamily::IPv6];
        yield ['127.0.0.1/24', 24, '127.0.0.1', IPFamily::IPv4];
        yield ['127.0.0.1', 32, '127.0.0.1', IPFamily::IPv4];
    }
}
