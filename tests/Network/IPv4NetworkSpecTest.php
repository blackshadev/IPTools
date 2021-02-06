<?php

declare(strict_types=1);


use Littledev\IPTools\Error\InvalidPrefixArgumentException;
use Littledev\IPTools\Network\IPv4Network;
use PHPUnit\Framework\TestCase;

class IPv4NetworkSpecTest extends TestCase
{
    public function testItParsesNetwork(): void
    {
        $network = IPv4Network::parse('127.0.0.1/24');

        self::assertEquals('127.0.0.1', $network->address());
        self::assertEquals(24, $network->subnet()->prefix());
    }

    public function testItDefaultsPrefixTo32(): void
    {
        $network = IPv4Network::parse('127.0.0.1');

        self::assertEquals(32, $network->subnet()->prefix());
    }

    public function testItThrowsOnInvalidPrefix(): void
    {
        $this->expectException(InvalidPrefixArgumentException::class);
        IPv4Network::parse('127.0.0.1/ab');
    }

    public function testItThrowsOnTooBigPrefix(): void
    {
        $this->expectException(InvalidPrefixArgumentException::class);
        IPv4Network::parse('127.0.0.1/64');
    }

    public function networkContainsDataProvider(): Generator
    {
        yield [
            '127.0.0.1/24',
            ['127.0.0.0', '127.0.0.255', '127.0.0.142'],
            ['8.8.8.8', '127.0.1.1', '1.0.0.42'],
        ];
        yield [
            '8.8.8.8/20',
            ['8.8.8.8', '8.8.0.0', '8.8.15.255', '8.8.11.42'],
            ['8.8.16.0', '8.7.255.255', '8.0.0.0'],
        ];
    }
}
