<?php

declare(strict_types=1);

namespace Littledev\IPTools\Address;

use Littledev\IPTools\Error\InvalidIPv4ArgumentException;
use Littledev\IPTools\Family\IPFamily;
use Littledev\IPTools\Family\IPFamilyInterface;
use Littledev\IPTools\Helper\ByteArray;
use Littledev\IPTools\Subnet\IPv4Subnet;
use Littledev\IPTools\Subnet\SubnetInterface;

class IPv4Address extends AbstractIPAddress
{
    public static function fromBinary(string $binaryString)
    {
        if (!preg_match('/^[01]{32}$/', $binaryString)) {
            throw InvalidIPv4ArgumentException::binary($binaryString);
        }

        return self::fromByteArray(ByteArray::fromBinaryString($binaryString));
    }

    public static function fromInAddr(string $inAddr)
    {
        return new self($inAddr);
    }

    public static function parse(string $address): self
    {
        if (!self::isValid($address)) {
            throw InvalidIPv4ArgumentException::address($address);
        }

        return self::fromInAddr(inet_pton($address));
    }

    public static function isValid(string $address): bool
    {
        return filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    public static function fromByteArray(array $byteArray): self
    {
        if (!ByteArray::isByteArray($byteArray) || count($byteArray) !== IPFamily::v4()->octets()) {
            throw InvalidIPv4ArgumentException::invalidByteArray($byteArray);
        }

        return self::fromInAddr(ByteArray::toInAddr($byteArray));
    }

    public function subnet(): SubnetInterface
    {
        return IPv4Subnet::fromPrefix($this->family()->maxPrefix());
    }

    public function reversePointer(): string
    {
        $reverseIp = implode('.', array_reverse(explode('.', (string)$this)));
        return $reverseIp . '.in-addr.arpa';
    }

    public function family(): IPFamilyInterface
    {
        return IPFamily::v4();
    }
}
