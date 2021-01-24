<?php

declare(strict_types=1);

namespace Littledev\IPTools\Subnet;

use Littledev\IPTools\Address\IPv4Address;
use Littledev\IPTools\Errors\InvalidPrefixArgumentException;
use Littledev\IPTools\IPFamily;

class IPv4Subnet implements SubnetInterface
{
    private $prefix;

    private IPv4Address $subnet;

    private function __construct()
    {
    }

    public function __toString(): string
    {
        return (string)$this->subnet;
    }

    public static function fromPrefix(int $prefix): self
    {
        if ($prefix < 0 || $prefix > self::MAX_IPv4) {
            throw InvalidPrefixArgumentException::invalidInput($prefix);
        }
        $subnet = new self();
        $subnet->prefix = $prefix;

        $binIP = str_repeat('1', $prefix) . str_repeat('0', self::MAX_IPv4 - $prefix);
        $subnet->subnet = IPv4Address::fromBinary($binIP);

        return $subnet;
    }

    public function version(): string
    {
        return IPFamily::IPv4;
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

    public function contains(SubnetInterface $subnet): bool
    {
        return $subnet->version() === $this->version()
            && $subnet->prefix() >= $this->prefix();
    }
}
