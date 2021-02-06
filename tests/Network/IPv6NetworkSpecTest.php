<?php

declare(strict_types=1);


use Littledev\IPTools\Error\InvalidPrefixArgumentException;
use Littledev\IPTools\Network\IPv6Network;
use PHPUnit\Framework\TestCase;

class IPv6NetworkSpecTest extends TestCase
{
    public function testItParsesNetwork(): void
    {
        $network = IPv6Network::parse('2001:db8::/64');

        self::assertEquals('2001:db8::', (string)$network->address());
        self::assertEquals(64, $network->subnet()->prefix());
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
