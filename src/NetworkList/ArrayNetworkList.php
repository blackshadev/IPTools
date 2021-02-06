<?php

declare(strict_types=1);

namespace Littledev\IPTools\NetworkList;

use Littledev\IPTools\AddressableInterface;
use Littledev\IPTools\Operator\NetworkOperators;

class ArrayNetworkList implements NetworkListInterface
{
    /** @var AddressableInterface[]  */
    private array $networks = [];

    /** @param AddressableInterface[] $networks */
    public static function fromArray(array $networks): self
    {
        $list = new self();
        $list->networks = $networks;
        return $list;
    }

    public function has(AddressableInterface $addressable): bool
    {
        /** @var AddressableInterface $network */
        foreach ($this->networks as $network) {
            if (NetworkOperators::contains($network, $addressable)) {
                return true;
            }
        }

        return false;
    }

    public function add(AddressableInterface $addressable): void
    {
        $this->networks[] = $addressable;
    }

    public function remove(AddressableInterface $addressable): void
    {
        foreach ($this->networks as $key => $network) {
            if ($this->isSame($network, $addressable)) {
                array_splice($this->networks, $key, 1);
            }
        }
    }

    public function get(AddressableInterface $addressable): array
    {
        $result = [];

        foreach ($this->networks as $network) {
            $result[] = $network;
        }

        return $result;
    }

    private function isSame(AddressableInterface $a, AddressableInterface $b): bool
    {
        return $a->address()->inAddr() === $b->address()->inAddr() &&
            $a->subnet()->prefix() === $b->subnet()->prefix();
    }
}
