<?php

declare(strict_types=1);

namespace Littledev\IPTools\Network;

use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Subnet\SubnetInterface;

abstract class AbstractIPNetwork implements NetworkInterface
{
    private AddressInterface $address;

    private SubnetInterface $subnet;

    protected function __construct(AddressInterface $address, SubnetInterface $subnet)
    {
        $this->address = $address;
        $this->subnet = $subnet;
    }

    public function __toString()
    {
        return $this->address . '/' . $this->subnet->prefix();
    }

    public function address(): AddressInterface
    {
        return $this->address;
    }

    public function subnet(): SubnetInterface
    {
        return $this->subnet;
    }
}
