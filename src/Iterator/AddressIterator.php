<?php

namespace Littledev\IPTools\Iterator;

use Littledev\IPTools\Network\NetworkInterface;
use Littledev\IPTools\Operator\NextIPOperator;
use Littledev\IPTools\Operator\OperatorInterface;

class AddressIterator extends AbstractNetworkIterator
{
    private OperatorInterface $nextOperator;

    public function __construct(NetworkInterface $network)
    {
        parent::__construct($network);
        $this->nextOperator = new NextIPOperator();
    }

    public function next()
    {
        $this->current = $this->nextOperator->execute($this->current);
    }
}
