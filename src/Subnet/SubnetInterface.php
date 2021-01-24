<?php

declare(strict_types=1);

namespace Littledev\IPTools\Subnet;

interface SubnetInterface
{
    public function version(): string;

    public function prefix(): int;

    public function inAddr(): string;

    public function byteArray(): array;

    public function contains(SubnetInterface $subnet): bool;
}
