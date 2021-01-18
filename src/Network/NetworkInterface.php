<?php

namespace Littledev\IPTools\Network;

use Littledev\IPTools\RoutableInterface;
use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Subnet\SubnetInterface;

interface NetworkInterface extends RoutableInterface
{
    public static function parse(string $network): self;
    public function address(): AddressInterface;
    public function subnet(): SubnetInterface;
    public function contains(RoutableInterface $address): bool;
    public function getLastIP(): AddressInterface;
    public function getFirstIP(): AddressInterface;

}
