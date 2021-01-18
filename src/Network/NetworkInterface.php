<?php

namespace Littledev\IPTools\Network;

use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Subnet\SubnetInterface;

interface NetworkInterface
{
    public static function parse(string $network): self;
    public function address(): AddressInterface;
    public function subnet(): SubnetInterface;
    public function contains(AddressInterface $address): bool;
    public function getLastIP(): AddressInterface;
    public function getFirstIP(): AddressInterface;

}
