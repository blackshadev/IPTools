<?php

declare(strict_types=1);

namespace Littledev\IPTools\Iterator;

use Littledev\IPTools\Operator\AddressOperators;
use Littledev\IPTools\Operator\NetworkOperators;

class AddressIterator extends AbstractNetworkIterator
{
    public function next()
    {
        $this->current = AddressOperators::nextIP($this->current);
    }

    public function rewind()
    {
        $this->current = NetworkOperators::firstIP($this->network);
    }
}
