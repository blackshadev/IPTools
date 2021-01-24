<?php

declare(strict_types=1);

namespace Littledev\IPTools\Network;

use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\AddressableInterface;
use Littledev\IPTools\Subnet\SubnetInterface;

interface NetworkInterface extends AddressableInterface
{
    public static function parse(string $network): self;

    public function address(): AddressInterface;

    public function subnet(): SubnetInterface;

    public function contains(AddressableInterface $address): bool;

    public function getLastIP(): AddressInterface;

    public function getFirstIP(): AddressInterface;
}
