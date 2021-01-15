<?php


namespace Littledev\IPTools;


interface NetworkInterface
{
    public function address(): AddressInterface;
    public function subnet(): SubnetInterface;
    public function contains(AddressInterface $address): bool;
    public function getBroadcast(): AddressInterface;
    public function getNetwork(): AddressInterface;

}
