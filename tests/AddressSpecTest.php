<?php

declare(strict_types=1);

use Littledev\IPTools\Address;
use Littledev\IPTools\Errors\InvalidAddressArgumentException;
use Littledev\IPTools\IPFamily;
use PHPUnit\Framework\TestCase;

class AddressSpecTest extends TestCase
{
    /**
     * @dataProvider validIPsProviders
     */
    public function testItParsesValidInput($input, $address, $family)
    {
        $ip = Address::parse($input);

        self::assertEquals($address, (string)$ip);
        self::assertEquals($family, $ip->version());
    }

    public function testItThrowsOnCIDR()
    {
        $this->expectException(InvalidAddressArgumentException::class);
        Address::parse('2001:db8::42/64');
    }

    public function testItThrowsOnGarbage()
    {
        $this->expectException(InvalidAddressArgumentException::class);
        Address::parse('nope');
    }

    public function validIPsProviders(): Generator
    {
        yield ['2001:db8::42', '2001:db8::42', IPFamily::IPv6];
        yield ['2001:db8::42', '2001:db8::42', IPFamily::IPv6];
        yield ['127.0.0.1', '127.0.0.1', IPFamily::IPv4];
        yield ['127.0.0.1', '127.0.0.1', IPFamily::IPv4];
    }
}
