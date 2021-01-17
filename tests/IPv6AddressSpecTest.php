<?php

use \PHPUnit\Framework\TestCase;
use Littledev\IPTools\Address\IPv6Address;
use Littledev\IPTools\Address\AddressInterface;

class IPv6AddressSpecTest extends TestCase
{
    public function testItParsesIPv4(): void
    {
        $value = '2001:db8::ff';
        $ip = IPv6Address::parse($value);
        self::assertEquals($value, (string)$ip);
        self::assertEquals(AddressInterface::IP_VERSION_6, $ip->version());
        self::assertEquals('f.f.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.0.8.b.d.0.1.0.0.2.ip6.arpa', $ip->reversePointer());
        self::assertEquals([32,1,13,184,0,0,0,0,0,0,0,0,0,0,0,255], $ip->byteArray());
        self::assertEquals(inet_pton($value), $ip->inAddr());
    }
}
