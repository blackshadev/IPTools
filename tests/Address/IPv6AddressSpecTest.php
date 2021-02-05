<?php

declare(strict_types=1);

use Littledev\IPTools\Address\IPv4Address;
use Littledev\IPTools\Address\IPv6Address;
use Littledev\IPTools\Error\InvalidIPv6ArgumentException;
use Littledev\IPTools\IPFamily;
use PHPUnit\Framework\TestCase;

class IPv6AddressSpecTest extends TestCase
{
    public function testItParsesIPv4(): void
    {
        $value = '2001:db8::ff';
        $ip = IPv6Address::parse($value);
        self::assertEquals($value, (string)$ip);
        self::assertEquals(IPFamily::IPv6, $ip->version());
        self::assertEquals('f.f.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.8.b.d.0.1.0.0.2.ip6.arpa', $ip->reversePointer());
        self::assertEquals([32, 1, 13, 184, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 255], $ip->byteArray());
        self::assertEquals(inet_pton($value), $ip->inAddr());
    }

    public function testItParsesByteArray(): void
    {
        $input = [127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127];
        $ip = IPv6Address::fromByteArray($input);
        self::assertEquals($input, $ip->byteArray());
    }

    /** @dataProvider invalidByteArrayProvider */
    public function testItThrowsOnInvalidByteArray($byteArray): void
    {
        $this->expectException(InvalidIPv6ArgumentException::class);
        IPv6Address::fromByteArray($byteArray);
    }

    public function testItParsesBinaryString(): void
    {
        $ip = IPv6Address::fromBinary('10101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010');
        self::assertEquals('aaaa:aaaa:aaaa:aaaa:aaaa:aaaa:aaaa:aaaa', (string)$ip);
    }

    public function testItThrowsOnTooShortBinaryString(): void
    {
        $this->expectException(InvalidIPv6ArgumentException::class);
        IPv6Address::fromBinary('10101010101010101010101010101010101010101010');
    }

    public function testItThrowsOnInvalidBinaryString(): void
    {
        $this->expectException(InvalidIPv6ArgumentException::class);
        IPv6Address::fromBinary('deadbeefcafe');
    }

    public function testItContains(): void
    {
        $addr = IPv6Address::parse('2001:db8::');
        self::assertTrue($addr->contains($addr));
        self::assertFalse($addr->contains(IPv4Address::parse('127.0.0.1')));
        self::assertFalse($addr->contains(IPv6Address::parse('2001:db8::1')));
    }

    public function invalidByteArrayProvider(): Generator
    {
        yield [ [] ];
        yield [ [127, 0, 0, 1] ];
        yield [ ['a', 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127] ];
        yield [ [127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127] ];
        yield [ [127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127, 127] ];
    }
}
