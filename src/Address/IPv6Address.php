<?php

declare(strict_types=1);

namespace Littledev\IPTools\Address;

use Littledev\IPTools\Error\InvalidIPv6ArgumentException;
use Littledev\IPTools\Family\IPFamily;
use Littledev\IPTools\Family\IPFamilyInterface;
use Littledev\IPTools\Helper\ByteArray;
use Littledev\IPTools\Subnet\IPv6Subnet;
use Littledev\IPTools\Subnet\SubnetInterface;

class IPv6Address extends AbstractIPAddress
{
    public static function isValid(string $address): bool
    {
        return filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    public static function fromBinary(string $binaryString): self
    {
        if (!preg_match('/^[01]{128}$/', $binaryString)) {
            throw InvalidIPv6ArgumentException::binary($binaryString);
        }

        $inAddr = '';
        foreach (ByteArray::fromBinaryString($binaryString) as $byte) {
            $inAddr .= pack('C*', $byte);
        }

        return new self($inAddr);
    }

    public static function parse(string $address): self
    {
        if (!self::isValid($address)) {
            throw InvalidIPv6ArgumentException::address($address);
        }

        return self::fromInAddr(inet_pton($address));
    }

    public static function fromInAddr(string $inAddr)
    {
        return new self($inAddr);
    }

    public static function fromByteArray(array $byteArray): self
    {
        if (!ByteArray::isByteArray($byteArray) || count($byteArray) !== IPFamily::v6()->octets()) {
            throw InvalidIPv6ArgumentException::invalidByteArray($byteArray);
        }

        return self::fromInAddr(ByteArray::toInAddr($byteArray));
    }

    public function family(): IPFamilyInterface
    {
        return IPFamily::v6();
    }

    public function subnet(): SubnetInterface
    {
        return IPv6Subnet::fromPrefix($this->family()->maxPrefix());
    }

    public function reversePointer(): string
    {
        $unpacked = unpack('H*hex', $this->inAddr());
        $reverseArray = array_reverse(mb_str_split($unpacked['hex']));
        return implode('.', $reverseArray) . '.ip6.arpa';
    }
}
