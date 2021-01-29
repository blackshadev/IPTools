<?php

declare(strict_types=1);

namespace Littledev\IPTools\NetworkMap\Tree;

use Littledev\IPTools\AddressableInterface;

interface NodeInterface
{
    public function key(): AddressableInterface;

    public function value();

    public function left(): ?NodeInterface;

    public function right(): ?NodeInterface;

    public function toArray(): array;
}
