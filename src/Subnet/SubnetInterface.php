<?php

declare(strict_types=1);

namespace Littledev\IPTools\Subnet;

interface SubnetInterface
{
    public const MAX_IPv4 = 32;

    public const MAX_IPv6 = 128;

    public function __toString(): string;

    public function version(): string;

    public function prefix(): int;

    public function inAddr(): string;

    public function byteArray(): array;

    public function contains(SubnetInterface $subnet): bool;
}
