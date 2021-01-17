<?php


namespace Littledev\IPTools\Network;


use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Address\IPv6Address;
use Littledev\IPTools\Subnet\IPv6Subnet;
use Littledev\IPTools\Subnet\SubnetInterface;

class IPv6Network implements NetworkInterface
{

    private IPv6Address $address;

    private IPv6Subnet $subnet;

    private function __construct(IPv6Address $address, IPv6Subnet $subnet)
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

    public function contains(AddressInterface $address): bool
    {
        return (strcmp($address->inAddr(), $this->getFirstIP()->inAddr()) >= 0)
            && (strcmp($address->inAddr(), $this->getLastIP()->inAddr()) <= 0);
    }

    public function getLastIP(): AddressInterface
    {
        return IPv6Address::fromInAddr($this->getFirstIP()->inAddr() | ~$this->subnet()->inAddr());
    }

    public function getFirstIP(): AddressInterface
    {
        return IPv6Address::fromInAddr($this->address()->inAddr() & $this->subnet()->inAddr());
    }
}
