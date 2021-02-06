<?php

declare(strict_types=1);

namespace Littledev\IPTools\Subnet;

use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Family\IPFamilyInterface;

abstract class AbstractIPSubnet implements SubnetInterface
{
    private int $prefix;

    private AddressInterface $subnet;

    protected function __construct(AddressInterface $subnet, int $prefix)
    {
        $this->subnet = $subnet;
        $this->prefix = $prefix;
    }

    public function __toString(): string
    {
        return (string)$this->subnet;
    }

    public function prefix(): int
    {
        return $this->prefix;
    }

    public function inAddr(): string
    {
        return $this->subnet->inAddr();
    }

    public function byteArray(): array
    {
        return $this->subnet->byteArray();
    }

    abstract public function family(): IPFamilyInterface;
}
