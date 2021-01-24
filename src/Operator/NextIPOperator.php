<?php


namespace Littledev\IPTools\Operator;


use Littledev\IPTools\Address;
use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Helper\ByteArray;

class NextIPOperator implements OperatorInterface
{
    public function execute(AddressInterface $address): AddressInterface
    {
        $byteArray = $address->byteArray();
        $nextByteArray = ByteArray::addOne($byteArray);

        return Address::byteArray($nextByteArray);
    }
}
