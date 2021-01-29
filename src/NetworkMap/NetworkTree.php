<?php

declare(strict_types=1);

namespace Littledev\IPTools\NetworkMap;

use Littledev\IPTools\AddressableInterface;
use Littledev\IPTools\NetworkMap\Tree\Node;
use Littledev\IPTools\NetworkMap\Tree\NodeInterface;

class NetworkTree implements NetworkMapInterface
{
    private ?NodeInterface $rootNode = null;

    public function find(AddressableInterface $addressable): array
    {
        $path = $this->path($addressable);
        return array_filter($path, fn ($node) => $node->key()->contains($addressable));
    }

    public function has(AddressableInterface $addressable): bool
    {
        return count($this->find($addressable)) > 0;
    }

    public function insert(AddressableInterface $addressable, $value)
    {
        $this->rootNode = Node::insert($this->rootNode, $addressable);
    }

    public function toArray(): array
    {
        return $this->rootNode === null ? [] : $this->rootNode->toArray();
    }

    private function path(AddressableInterface $addressable): array
    {
        if ($this->rootNode === null) {
            return [];
        }

        $path = [$this->rootNode];
        $node = $this->rootNode;

        while ($node !== null) {
            $relative = Node::compare($node->key(), $addressable);
            if ($relative <= 0) {
                $node = $node->left();
            } else {
                $node = $node->right();
            }
        }

        return $path;
    }
}
