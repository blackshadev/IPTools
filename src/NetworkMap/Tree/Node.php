<?php

declare(strict_types=1);

namespace Littledev\IPTools\NetworkMap\Tree;

use Littledev\IPTools\AddressableInterface;

class Node implements NodeInterface
{
    private $value;

    private AddressableInterface $key;

    private ?NodeInterface $left = null;

    private ?NodeInterface $right = null;

    private function __construct(AddressableInterface $key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    public static function insert(?NodeInterface $node, AddressableInterface $key, $value = null): NodeInterface
    {
        if ($node === null) {
            return new self($key, $value);
        }

        $relative = self::compare($node->key, $key);
        if ($relative <= 0) {
            $node->left = self::insert($node->left, $key, $value);
        }

        $node->right = self::insert($node->right, $key, $value);

        return $node;
    }

    public static function compare(AddressableInterface $a, AddressableInterface $b): int
    {
        $inAddrA = $a->address()->inAddr();
        $inAddrB = $b->address()->inAddr();

        if ($inAddrA < $inAddrB) {
            return -1;
        }

        if ($inAddrA > $inAddrB) {
            return 1;
        }

        return 0;
    }

    public function key(): AddressableInterface
    {
        return $this->key;
    }

    public function value()
    {
        return $this->value;
    }

    public function left(): ?NodeInterface
    {
        return $this->left;
    }

    public function right(): ?NodeInterface
    {
        return $this->right;
    }

    public function toArray(): array
    {
        return [
            'key' => (string)$this->key,
            'value' => $this->value,
            'left' => $this->left !== null ? $this->left->toArray() : null,
            'right' => $this->right !== null ? $this->right->toArray() : null
        ];
    }
}
