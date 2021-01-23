<?php

namespace Littledev\IPTools\Subnet;

interface SubnetInterface
{
    public function version(): string;
    public function prefix(): int;
    public function inAddr(): string;
    public function byteArray(): array;
    public function contains(SubnetInterface $subnet): bool;
    public function __toString(): string;
}
