<?php


namespace Littledev\IPTools\Network;


use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Subnet\SubnetInterface;

class IPv6Network implements NetworkInterface
{


    private function __construct()
    { }

    public function address(): AddressInterface
    {
        // TODO: Implement address() method.
    }

    public function subnet(): SubnetInterface
    {
        // TODO: Implement subnet() method.
    }

    public function contains(AddressInterface $address): bool
    {
        // TODO: Implement contains() method.
    }

    public function getBroadcast(): AddressInterface
    {
        // TODO: Implement getBroadcast() method.
    }

    public function getNetwork(): AddressInterface
    {
        // TODO: Implement getNetwork() method.
    }
}
