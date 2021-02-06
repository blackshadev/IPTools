<?php

declare(strict_types=1);

namespace Littledev\IPTools\Address;

use Littledev\IPTools\AddressableInterface;
use Littledev\IPTools\Family\IPFamilyInterface;

interface AddressInterface extends AddressableInterface
{
    public function __toString(): string;

    public function reversePointer(): string;

    public function inAddr(): string;

    public function byteArray(): array;

    public function family(): IPFamilyInterface;
}
