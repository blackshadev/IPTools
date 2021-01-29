<?php

declare(strict_types=1);

namespace NetworkMap;

use Littledev\IPTools\Address;
use Littledev\IPTools\Network;
use Littledev\IPTools\NetworkMap\NetworkTree;
use PHPUnit\Framework\TestCase;

class NetworkTreeTest extends TestCase
{
    public function testItWorks()
    {
        $tree = new NetworkTree();
        $tree->insert(Network::parse('127.0.0.0/24'), 'localhost');
        $tree->insert(Network::parse('127.0.0.0/16'), 'localerhost');
        $tree->insert(Network::parse('10.0.0.0/16'), 'other local network');
        $tree->insert(Network::parse('192.168.1.0/24'), 'LAN1');
        $tree->insert(Network::parse('192.168.1.17/32'), 'ME');
        $tree->insert(Network::parse('192.168.1.254/32'), 'SHE');
        $tree->insert(Network::parse('192.168.1.1/32'), 'Gateway');
        $tree->insert(Network::parse('10.0.0.0/16'), 'Uber LAN');
        $tree->insert(Network::parse('10.0.42.42/30'), 'They');

        $d = $tree->find(Address::parse('127.0.0.1'));
        var_dump(count($d));
    }
}
