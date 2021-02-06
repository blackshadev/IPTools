<?php

declare(strict_types=1);

namespace Littledev\IPTools\Address;

use Littledev\IPTools\Family\IPFamilyInterface;
use Littledev\IPTools\Subnet\SubnetInterface;

abstract class AbstractIPAddress implements AddressInterface
{
    private string $inAddr;

    protected function __construct(string $inAddr)
    {
        $this->inAddr = $inAddr;
    }

    public function __toString(): string
    {
        return inet_ntop($this->inAddr());
    }

    public function inAddr(): string
    {
        return $this->inAddr;
    }

    public function byteArray(): array
    {
        return array_values(unpack('C*', $this->inAddr));
    }

    public function address(): AddressInterface
    {
        return $this;
    }

    abstract public function subnet(): SubnetInterface;

    abstract public function family(): IPFamilyInterface;

    abstract public function reversePointer(): string;
}
