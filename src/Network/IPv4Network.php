<?php

namespace Littledev\IPTools\Network;

use Littledev\IPTools\RoutableInterface;
use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Address\IPv4Address;
use Littledev\IPTools\Helpers\Prefix;
use Littledev\IPTools\Subnet\IPv4Subnet;
use Littledev\IPTools\Subnet\SubnetInterface;

class IPv4Network implements NetworkInterface
{
    private IPv4Address $address;
    private IPv4Subnet $subnet;

    public static function parse(string $cidr): self
    {
        $arr = explode('/', $cidr);

        $ip = $arr[0];
        $prefix = Prefix::prefixAsInt($arr[1] ?? null, SubnetInterface::MAX_IPv4);

        return new self(
            IPv4Address::parse($ip),
            IPv4Subnet::fromPrefix($prefix)
        );
    }

    private function __construct(IPv4Address $address, IPv4Subnet $subnet)
    {
        $this->address = $address;
        $this->subnet = $subnet;
    }

    public function address(): AddressInterface
    {
        return $this->address;
    }

    public function subnet(): SubnetInterface
    {
        return $this->subnet;
    }

    public function contains(RoutableInterface $address): bool
    {
        if ($address instanceof NetworkInterface) {
            $address = $address->address();
        }

        return (strcmp($address->inAddr(), $this->getFirstIP()->inAddr()) >= 0)
            && (strcmp($address->inAddr(), $this->getLastIP()->inAddr()) <= 0);
    }

    public function getLastIP(): AddressInterface
    {
        return IPv4Address::fromInAddr($this->getFirstIP()->inAddr() | ~$this->subnet()->inAddr());
    }

    public function getFirstIP(): AddressInterface
    {
        return IPv4Address::fromInAddr($this->address()->inAddr() & $this->subnet()->inAddr());
    }
}
