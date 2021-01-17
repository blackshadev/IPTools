<?php

namespace Littledev\IPTools\Address;

use Littledev\IPTools\Errors\InvalidIPv6ArgumentException;
use Littledev\IPTools\Helpers\ByteArray;

class IPv6Address implements AddressInterface
{

    public static function isValid(string $address): bool
    {
        return filter_var($address, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) !== false;
    }

    public static function fromBinary(string $binaryString): self
    {
        if(!preg_match('/^[01]{64}$/', $binaryString)) {
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

        return new self(inet_pton($address));
    }

    public static function fromInAddr(string $inAddr)
    {
        return new self($inAddr);
    }

    private string $inAddr;

    private function __construct(string $inAddr)
    {
        $this->inAddr = $inAddr;
    }

    public function version(): string
    {
        return AddressInterface::IP_VERSION_6;
    }

    public function reversePointer(): string
    {
        $unpacked = unpack('H*hex', $this->inAddr);
        $reverseArray = array_reverse(str_split($unpacked['hex']));
        $reversePointer = implode('.', $reverseArray) . '.ip6.arpa';
        return $reversePointer;
    }

    public function inAddr(): string
    {
        return $this->inAddr;
    }

    public function byteArray(): array
    {
        return array_values(unpack('C*', $this->inAddr));
    }

    public function __toString(): string
    {
        return inet_ntop($this->inAddr);
    }
}
