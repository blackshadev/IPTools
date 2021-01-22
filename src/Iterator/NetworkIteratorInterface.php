<?php


namespace Littledev\IPTools\Iterator;

use Littledev\IPTools\AddressableInterface;
use Littledev\IPTools\Network\NetworkInterface;

interface NetworkIteratorInterface extends \Iterator
{
    public function __construct(NetworkInterface $network);
    public function current(): AddressableInterface;
}
