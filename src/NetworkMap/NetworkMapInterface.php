<?php

declare(strict_types=1);

namespace Littledev\IPTools\NetworkMap;

use Littledev\IPTools\AddressableInterface;

interface NetworkMapInterface
{
    public function has(AddressableInterface $addressable): bool;

    public function find(AddressableInterface $addressable): array;

    public function insert(AddressableInterface $addressable, $value);
}
