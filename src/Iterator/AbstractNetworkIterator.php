<?php

declare(strict_types=1);

namespace Littledev\IPTools\Iterator;

use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\AddressableInterface;
use Littledev\IPTools\Network\NetworkInterface;
use Littledev\IPTools\Operator\NetworkOperators;

abstract class AbstractNetworkIterator implements NetworkIteratorInterface
{
    protected NetworkInterface $network;

    protected AddressInterface $current;

    public function __construct(NetworkInterface $network)
    {
        $this->network = $network;
    }

    abstract public function next();

    abstract public function rewind();

    public function key()
    {
        return null;
    }

    public function valid()
    {
        return NetworkOperators::contains($this->network, $this->current);
    }

    public function current(): AddressableInterface
    {
        return $this->current;
    }
}
