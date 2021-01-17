<?php

namespace Littledev\IPTools\Network;

use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Subnet\SubnetInterface;

interface NetworkInterface
{
    public function address(): AddressInterface;
    public function subnet(): SubnetInterface;
    public function contains(AddressInterface $address): bool;
    public function getBroadcast(): AddressInterface;
    public function getNetwork(): AddressInterface;

}
