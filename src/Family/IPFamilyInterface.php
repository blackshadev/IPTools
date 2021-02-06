<?php

declare(strict_types=1);


namespace Littledev\IPTools\Family;

interface IPFamilyInterface
{
    public function name(): string;

    public function maxPrefix(): int;

    public function octets(): int;
}
