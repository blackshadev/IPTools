<?php

namespace Littledev\IPTools\Subnet;

interface SubnetInterface
{
    const MAX_IPv4 = 32;
    const MAX_IPv6 = 128;

    public function prefix(): int;
    public function inAddr(): string;
    public function byteArray(): array;
    public function __toString(): string;

}
