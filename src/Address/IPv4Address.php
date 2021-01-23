<?php

declare(strict_types=1);

namespace Littledev\IPTools\Address;

use Littledev\IPTools\Error\InvalidIPv4ArgumentException;
use Littledev\IPTools\Helper\ByteArray;
use Littledev\IPTools\IPFamily;
use Littledev\IPTools\Subnet\IPv4Subnet;
use Littledev\IPTools\Subnet\SubnetInterface;

class IPv4Address implements AddressInterface
{
    public static function fromBinary(string $binaryString)
    {
        if(!preg_match('/^[01]{32}$/', $binaryString)) {
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

        return new self(inet_pton($address));
    }

    public static function isValid(string $address): bool
    {
        return filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) !== false;
    }

    public static function fromByteArray(array $byteArray): self
    {
        if (!ByteArray::isByteArray($byteArray) || count($byteArray) !== IPFamily::OCTET_IPv4) {
            throw InvalidIPv4ArgumentException::invalidByteArray($byteArray);
        }

        return new self(ByteArray::toInAddr($byteArray));
    }

    private string $address;

    private function __construct(string $inAddr)
    {
        $this->address = $inAddr;
    }

    public function version(): string
    {
        return IPFamily::IPv4;
    }

    public function address(): AddressInterface
    {
        return $this;
    }

    public function subnet(): SubnetInterface
    {
        return IPv4Subnet::fromPrefix(IPFamily::MAX_PREFIX_IPv4);
    }

    public function reversePointer(): string
    {
        $reverseIp = implode('.', array_reverse(explode('.', (string)$this)));
        return $reverseIp . '.in-addr.arpa';
    }

    public function inAddr(): string
    {
        return $this->address;
    }

    public function byteArray(): array
    {
        return array_values(unpack('C*', $this->address));
    }

    public function __toString(): string
    {
        return inet_ntop($this->inAddr());
    }
}
