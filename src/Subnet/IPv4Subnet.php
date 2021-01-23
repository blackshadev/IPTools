<?php

namespace Littledev\IPTools\Subnet;

use Littledev\IPTools\Address\IPv4Address;
use Littledev\IPTools\Error\InvalidPrefixArgumentException;
use Littledev\IPTools\IPFamily;

class IPv4Subnet implements SubnetInterface
{
    public static function fromPrefix(int $prefix): self
    {
        if ($prefix < 0 || $prefix > IPFamily::MAX_PREFIX_IPv4) {
            throw InvalidPrefixArgumentException::invalidInput($prefix);
        }
        $subnet = new self();
        $subnet->prefix = $prefix;

        $binIP = str_repeat('1', $prefix) . str_repeat('0', IPFamily::MAX_PREFIX_IPv4 - $prefix);
        $subnet->subnet = IPv4Address::fromBinary($binIP);

        return $subnet;
    }

    private $prefix;
    private IPv4Address $subnet;

    private function __construct()
    { }

    public function version(): string
    {
        return IPFamily::IPv4;
    }

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

    public function contains(SubnetInterface $subnet): bool
    {
        return $subnet->version() === $this->version()
            && $subnet->prefix() >= $this->prefix();
    }
}
