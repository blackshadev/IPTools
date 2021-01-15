<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;

use Littledev\IPTools\Errors\InvalidIPv4ArgumentException;
use Littledev\IPTools\IPv4Address;
use Littledev\IPTools\AddressInterface;

class IPv4AddressSpecTest extends TestCase
{
    public function testItParsesIPv4(): void
    {
        $value = '127.1.9.254';
        $ip = IPv4Address::parse($value);
        self::assertEquals($value, (string)$ip);
        self::assertEquals(AddressInterface::IP_VERSION_4, $ip->version());
        self::assertEquals('254.9.1.127.in-addr.arpa', $ip->reversePointer());
        self::assertEquals([127,1,9,254], $ip->byteArray());
        self::assertEquals(inet_pton($value), $ip->inAddr());
    }

    public function testItThrowsOnIPv4(): void
    {
        $this->expectException(InvalidIPv4ArgumentException::class);
        IPv4Address::parse(':::dead:beef:cafe');
    }

    public function testItThrowsOnOutOfRangeValue(): void
    {
        $this->expectException(InvalidIPv4ArgumentException::class);
        IPv4Address::parse('127.0.0.256');
    }

    public function testItThrowsOnInvalidValue(): void
    {
        $this->expectException(InvalidIPv4ArgumentException::class);
        IPv4Address::parse('POPE OF NOPE!');
    }

    public function testItThrowsOnIncompleteValue(): void
    {
        $this->expectException(InvalidIPv4ArgumentException::class);
        IPv4Address::parse('127.0.0');
    }
}
