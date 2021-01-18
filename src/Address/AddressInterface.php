<?php

namespace Littledev\IPTools\Address;

use Littledev\IPTools\RoutableInterface;

interface AddressInterface extends RoutableInterface
{
    public function version(): string;
    public function reversePointer(): string;
    public function inAddr(): string;
    public function byteArray(): array;
    public function __toString(): string;
}
