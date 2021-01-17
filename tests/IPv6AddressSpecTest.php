<?php

use \PHPUnit\Framework\TestCase;
use Littledev\IPTools\Address\IPv6Address;
use Littledev\IPTools\Address\AddressInterface;

class IPv6AddressSpecTest extends TestCase
{
    public function testItParsesIPv4(): void
    {
        $value = '2a02:898:194:34::ff';
        $ip = IPv6Address::parse($value);
        self::assertEquals($value, (string)$ip);
        self::assertEquals(AddressInterface::IP_VERSION_6, $ip->version());
        self::assertEquals('f.f.0.0.0.0.0.0.0.0.0.0.0.0.0.0.4.3.0.0.4.9.1.0.8.9.8.0.2.0.a.2.ip6.arpa', $ip->reversePointer());
        self::assertEquals([42,2,8,152,1,148,0,52,0,0,0,0,0,0,0,255], $ip->byteArray());
        self::assertEquals(inet_pton($value), $ip->inAddr());
    }
}
