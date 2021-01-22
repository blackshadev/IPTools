<?php

namespace Littledev\IPTools\Operator;

use Littledev\IPTools\Address\AddressInterface;

interface OperatorInterface {
    public function execute(AddressInterface $address): AddressInterface;
}
