<?php

declare(strict_types=1);

namespace Littledev\IPTools\Subnet;

use Littledev\IPTools\Family\IPFamilyInterface;

interface SubnetInterface
{
    public function family(): IPFamilyInterface;

    public function prefix(): int;

    public function inAddr(): string;

    public function byteArray(): array;
}
