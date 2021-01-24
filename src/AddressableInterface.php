<?php

declare(strict_types=1);

namespace Littledev\IPTools;

use Littledev\IPTools\Address\AddressInterface;
use Littledev\IPTools\Subnet\SubnetInterface;

interface AddressableInterface
{
    public function address(): AddressInterface;

    public function subnet(): SubnetInterface;
}
