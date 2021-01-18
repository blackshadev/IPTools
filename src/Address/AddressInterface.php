<?php

namespace Littledev\IPTools\Address;

interface AddressInterface
{
    const IP_VERSION_4 = "IPv4";
    const IP_VERSION_6 = "IPv6";

    public function version(): string;
    public function reversePointer(): string;
    public function inAddr(): string;
    public function byteArray(): array;
    public function __toString(): string;
}
