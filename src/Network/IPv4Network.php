<?php

declare(strict_types=1);

namespace Littledev\IPTools\Network;

use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Address\IPv4Address;
use Littledev\IPTools\AddressableInterface;
use Littledev\IPTools\Helper\Prefix;
use Littledev\IPTools\IPFamily;
use Littledev\IPTools\Subnet\IPv4Subnet;
use Littledev\IPTools\Subnet\SubnetInterface;

class IPv4Network implements NetworkInterface
{
    private IPv4Address $address;

    private IPv4Subnet $subnet;

    private function __construct(IPv4Address $address, IPv4Subnet $subnet)
    {
        $this->address = $address;
        $this->subnet = $subnet;
    }

    public function __toString()
    {
        return $this->address . '/' . $this->subnet->prefix();
    }

    public static function parse(string $cidr): self
    {
        $arr = explode('/', $cidr);

        $ip = IPv4Address::parse($arr[0]);
        $prefix = Prefix::prefixAsInt($arr[1] ?? null, IPFamily::MAX_PREFIX_IPv4);

        return new self(
            $ip,
            IPv4Subnet::fromPrefix($prefix)
        );
    }

    public function address(): AddressInterface
    {
        return $this->address;
    }

    public function subnet(): SubnetInterface
    {
        return $this->subnet;
    }

    public function contains(AddressableInterface $address): bool
    {
        return (strcmp($address->address()->inAddr(), $this->getFirstIP()->inAddr()) >= 0)
            && (strcmp($address->address()->inAddr(), $this->getLastIP()->inAddr()) <= 0)
            && $this->subnet->contains($address->subnet());
    }

    public function getLastIP(): AddressInterface
    {
        return IPv4Address::fromInAddr($this->getFirstIP()->inAddr() | ~$this->subnet()->inAddr());
    }

    public function getFirstIP(): AddressInterface
    {
        return IPv4Address::fromInAddr($this->address()->inAddr() & $this->subnet()->inAddr());
    }
}
