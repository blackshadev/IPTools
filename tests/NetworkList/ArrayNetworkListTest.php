<?php

declare(strict_types=1);

namespace NetworkList;

use Littledev\IPTools\Address;
use Littledev\IPTools\Network;
use Littledev\IPTools\NetworkList\ArrayNetworkList;
use PHPUnit\Framework\TestCase;

class ArrayNetworkListTest extends TestCase
{
    public function test_it_adds_and_finds_ipv4_network(): void
    {
        $list = new ArrayNetworkList();
        $addr = Network::ipv4('127.0.0.1/24');

        $list->add($addr);

        self::assertTrue($list->has(Address::ipv4('127.0.0.42')));
        self::assertFalse($list->has(Address::ipv4('127.1.0.42')));
        self::assertFalse($list->has(Address::ipv6('::127.1.0.42')));

        $retrieved = $list->get(Address::ipv4('127.0.0.42'));
        self::assertCount(1, $retrieved);
        self::assertSame($addr, $retrieved[0]);
    }

    public function test_it_gets_multiple_results(): void
    {
        $list = new ArrayNetworkList();
        $addr1 = Network::ipv4('127.0.0.1/24');
        $addr2 = Network::ipv4('127.0.0.1/16');

        $list->add($addr1);
        $list->add($addr2);

        $retrieved = $list->get(Address::ipv4('127.0.0.1'));
        self::assertCount(2, $retrieved);
        self::assertSame($addr1, $retrieved[0]);
        self::assertSame($addr2, $retrieved[1]);
    }

    public function test_it_removes_ip(): void
    {
        $list = new ArrayNetworkList();
        $addr1 = Network::ipv4('127.0.0.1/24');
        $addr2 = Network::ipv4('127.1.0.1/24');
        $addr3 = Network::ipv4('127.0.0.1/32');

        $list->add($addr1);
        $list->add($addr2);
        $list->add($addr3);
        $list->remove($addr1);

        self::assertFalse($list->has(Address::ipv4('127.0.0.24')));
        self::assertTrue($list->has(Address::ipv4('127.0.0.1')));
        self::assertTrue($list->has(Address::ipv4('127.1.0.1')));
    }

    public function test_it_adds_and_finds_ipv6_network(): void
    {
        $list = new ArrayNetworkList();
        $addr1 = Network::ipv6('2001:db8::/64');

        $list->add($addr1);

        self::assertTrue($list->has(Address::ipv6('2001:db8::1')));
        self::assertFalse($list->has(Address::ipv6('2001:db8:1::1')));

        $retrieved = $list->get(Address::ipv4('127.0.0.42'));
        self::assertCount(1, $retrieved);
        self::assertSame($addr1, $retrieved[0]);
    }

    public function test_it_creates_list_from_array(): void
    {
        $list = ArrayNetworkList::fromArray([
            Network::parse('127.0.0.1/24'),
            Network::parse('2001:db8::/64'),
            Network::parse('2001:db8::/128')
        ]);

        self::assertTrue($list->has(Address::ipv6('2001:db8::')));
    }
}
