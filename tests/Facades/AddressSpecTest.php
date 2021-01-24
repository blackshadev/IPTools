<?php

declare(strict_types=1);

use Littledev\IPTools\Address;
use Littledev\IPTools\Error\InvalidAddressArgumentException;
use Littledev\IPTools\Error\InvalidIPv4ArgumentException;
use Littledev\IPTools\Error\InvalidIPv6ArgumentException;
use Littledev\IPTools\IPFamily;
use PHPUnit\Framework\TestCase;

class AddressSpecTest extends TestCase
{
    /**
     * @dataProvider validIPv4Provider
     * @dataProvider validIPv6Provider
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

    public function testItThrowsOnInvalidParseInput()
    {
        $this->expectException(InvalidAddressArgumentException::class);
        Address::parse('nope');
    }

    /**
     * @dataProvider  validByteArrayProvider
     */
    public function testItParsesByteArray($byteArray, $family)
    {
        $addr = Address::byteArray($byteArray);
        self::assertEquals($byteArray, $addr->byteArray());
        self::assertEquals($family, $addr->version());
    }

    public function testItThrowsOnInvalidByteArray()
    {
        $this->expectException(InvalidAddressArgumentException::class);
        Address::byteArray([]);
    }

    public function validByteArrayProvider(): Generator
    {
        yield [ [127, 0, 0, 1  ], IPFamily::IPv4];
        yield [ [127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127], IPFamily::IPv6];
    }

    /**
     * @dataProvider validIPv4Provider
     */
    public function testItParsesIPv4($input, $address)
    {
        $ip = Address::ipv4($input);

        self::assertEquals($address, (string)$ip);
        self::assertEquals(IPFamily::IPv4, $ip->version());
    }

    /**
     * @dataProvider validIPv6Provider
     */
    public function testItParsesIPv6($input, $address)
    {
        $ip = Address::ipv6($input);

        self::assertEquals($address, (string)$ip);
        self::assertEquals(IPFamily::IPv6, $ip->version());
    }

    /**
    * @dataProvider validIPv4Provider
    */
    public function testIPv6ParserFailsOnIPv4($input)
    {
        $this->expectException(InvalidIPv6ArgumentException::class);
        Address::ipv6($input);
    }

    /**
    * @dataProvider validIPv6Provider
    */
    public function testIPv4ParserFailsOnIPv6($input)
    {
        $this->expectException(InvalidIPv4ArgumentException::class);
        Address::ipv4($input);
    }

    /**
     * @dataProvider validIPv4Provider
     * @dataProvider validIPv6Provider
     */
    public function testItDetectsIPv4Family($cidr, $_, $expectedFamily)
    {
        $family = Address::family($cidr);
        self::assertEquals($expectedFamily, $family);
    }

    public function testItThrowsOnInvalidIP()
    {
        $family = Address::family('127.0.a.1');
        self::assertEquals(IPFamily::Invalid, $family);
    }

    public function validIPv4Provider(): Generator
    {
        yield ['127.0.0.1', '127.0.0.1', IPFamily::IPv4];
        yield ['8.8.8.8', '8.8.8.8', IPFamily::IPv4];
    }

    public function validIPv6Provider(): Generator
    {
        yield ['2001:db8::42', '2001:db8::42', IPFamily::IPv6];
        yield ['2001:db8::1:1', '2001:db8::1:1', IPFamily::IPv6];
    }
}
