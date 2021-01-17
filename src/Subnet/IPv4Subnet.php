<?php

namespace Littledev\IPTools\Subnet;

use Littledev\IPTools\Address\IPv4Address;

class IPv4Subnet implements SubnetInterface
{

    public static function fromPrefix(int $prefix): self
    {
        $subnet = new self();
        $subnet->prefix = $prefix;

        $binIP = str_repeat('1', $prefix) . str_repeat('0', self::MAX_IPv4 - $prefix);
        $subnet->subnet = IPv4Address::fromBinary($binIP);

        return $subnet;
    }

    private $prefix;
    private IPv4Address $subnet;

    private function __construct()
    { }

    public function prefix(): int
    {
        return $this->prefix;
    }

    public function __toString(): string
    {
        return (string)$this->subnet;
    }

    public function inAddr(): string
    {
        return $this->subnet->inAddr();
    }

    public function byteArray(): array
    {
        return $this->subnet->byteArray();
    }
}
