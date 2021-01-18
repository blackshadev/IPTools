<?php

namespace Littledev\IPTools\Address;

interface AddressInterface
{
    public function version(): string;
    public function reversePointer(): string;
    public function inAddr(): string;
    public function byteArray(): array;
    public function __toString(): string;
}
