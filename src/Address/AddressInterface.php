<?php

declare(strict_types=1);

namespace Littledev\IPTools\Address;

use Littledev\IPTools\AddressableInterface;

interface AddressInterface extends AddressableInterface
{
    public function __toString(): string;

    public function version(): string;

    public function reversePointer(): string;

    public function inAddr(): string;

    public function byteArray(): array;
}
