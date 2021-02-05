<?php

declare(strict_types=1);

namespace Littledev\IPTools\NetworkList;

use Littledev\IPTools\AddressableInterface;

interface NetworkListInterface
{
    public function has(AddressableInterface $addressable): bool;

    public function add(AddressableInterface $addressable): void;

    public function remove(AddressableInterface $addressable): void;

    /**
     * @return AddressableInterface[]
     */
    public function get(AddressableInterface $addressable): array;
}
