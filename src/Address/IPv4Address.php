<?php

declare(strict_types=1);

namespace Littledev\IPTools\Address;

use Littledev\IPTools\Errors\InvalidIPv4ArgumentException;
use Littledev\IPTools\Helpers\ByteArray;
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

        $inAddr = '';
		foreach (ByteArray::fromBinaryString($binaryString) as $byte) {
			$inAddr .= pack('C*', $byte);
		}

		return new self($inAddr);
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
        return IPv4Subnet::fromPrefix(SubnetInterface::MAX_IPv4);
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
