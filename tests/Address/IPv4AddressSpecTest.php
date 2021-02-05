<?php

declare(strict_types=1);

use Littledev\IPTools\Address\IPv4Address;
use Littledev\IPTools\Address\IPv6Address;
use Littledev\IPTools\Error\InvalidIPv4ArgumentException;
use Littledev\IPTools\IPFamily;
use PHPUnit\Framework\TestCase;

class IPv4AddressSpecTest extends TestCase
{
    public function testItParsesIPv4(): void
    {
        $value = '127.1.9.254';
        $ip = IPv4Address::parse($value);
        self::assertEquals($value, (string)$ip);
        self::assertEquals(IPFamily::IPv4, $ip->version());
        self::assertEquals('254.9.1.127.in-addr.arpa', $ip->reversePointer());
        self::assertEquals([127, 1, 9, 254], $ip->byteArray());
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

    public function testItParsesBinaryString(): void
    {
        $ip = IPv4Address::fromBinary('10101010101010101010101010101010');
        self::assertEquals('170.170.170.170', (string)$ip);
    }

    public function testItThrowsOnTooShortBinaryString(): void
    {
        $this->expectException(InvalidIPv4ArgumentException::class);
        $this->expectExceptionMessage(sprintf(InvalidIPv4ArgumentException::BINARY, '1010101010101010'));
        IPv4Address::fromBinary('1010101010101010');
    }

    public function testItThrowsOnInvalidBinaryString(): void
    {
        $this->expectException(InvalidIPv4ArgumentException::class);
        $this->expectExceptionMessage(sprintf(InvalidIPv4ArgumentException::BINARY, 'deadbeefcafe'));
        IPv4Address::fromBinary('deadbeefcafe');
    }

    public function testItParsesByteArray(): void
    {
        $input = [127, 0, 0, 1];
        $ip = IPv4Address::fromByteArray($input);
        self::assertEquals($input, $ip->byteArray());
    }

    /** @dataProvider invalidByteArrayProvider */
    public function testItThrowsOnInvalidByteArray($byteArray): void
    {
        $this->expectException(InvalidIPv4ArgumentException::class);
        IPv4Address::fromByteArray($byteArray);
    }

    public function testItContains(): void
    {
        $addr = IPv4Address::parse('127.0.0.1');
        self::assertTrue($addr->contains($addr));
        self::assertFalse($addr->contains(IPv4Address::parse('127.0.0.0')));
        self::assertFalse($addr->contains(IPv6Address::parse('::127.0.0.0')));
    }

    public function invalidByteArrayProvider(): Generator
    {
        yield [ [] ];
        yield [ ['a', 0, 0, 1] ];
        yield [ [256, 0, 0, 1] ];
        yield [ [127, 0, 0, -1] ];
        yield [ [127, 0, 0, 1, 1] ];
        yield [ [127, 0, 0] ];
        yield [ [127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127] ];
    }
}
