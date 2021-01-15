<?php

namespace Littledev\IPTools;

use Littledev\IPTools\Helpers\Prefix;

class IPv4Network implements NetworkInterface
{
    private IPv4Address $address;
    private IPv4Subnet $subnet;

    public static function parse(string $cidr): self
    {
        $arr = explode('/', $cidr);

        $ip = $arr[0];
        $prefix = Prefix::prefixAsInt($arr[1] ?? null, IPv4Subnet::MAX_IPv4);

        return new self(
            IPv4Address::parse($ip),
            IPv4Subnet::fromPrefix($prefix)
        );
    }

    private function __construct(IPv4Address $address, IPv4Subnet $subnet)
    {
        $this->address = $address;
        $this->subnet = $subnet;
    }

    public function address(): AddressInterface
    {
        return $this->address;
    }

    public function subnet(): SubnetInterface
    {
        return $this->subnet;
    }

    public function contains(AddressInterface $address): bool
    {
        return (strcmp($address->inAddr(), $this->getNetwork()->inAddr()) >= 0)
            && (strcmp($address->inAddr(), $this->getBroadcast()->inAddr()) <= 0);
    }

    public function getBroadcast(): AddressInterface
    {
        return IPv4Address::fromInAddr($this->getNetwork()->inAddr() | ~$this->subnet()->inAddr());
    }

    public function getNetwork(): AddressInterface
    {
        return IPv4Address::fromInAddr($this->address()->inAddr() & $this->subnet()->inAddr());
    }
}
