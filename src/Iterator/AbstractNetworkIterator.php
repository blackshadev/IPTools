<?php

namespace Littledev\IPTools\Iterator;

use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\AddressableInterface;
use Littledev\IPTools\Network\NetworkInterface;

abstract class AbstractNetworkIterator implements NetworkIteratorInterface
{

    protected NetworkInterface $network;
    protected AddressInterface $current;

    public function __construct(NetworkInterface $network)
    {
        $this->network = $network;
        $this->current = $network->getFirstIP();
    }

    abstract public function next();

    public function key()
    {
        return null;
    }

    public function valid()
    {
        return $this->network->contains($this->current);
    }

    public function rewind()
    {
        $this->current = $this->network->getFirstIP();
    }


    public function current(): AddressableInterface
    {
        return $this->current;
    }
}
