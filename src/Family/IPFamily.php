<?php

declare(strict_types=1);

namespace Littledev\IPTools\Family;

class IPFamily implements IPFamilyInterface
{
    public const NAME_V4 = 'IPv4';

    public const NAME_V6 = 'IPv6';

    public const NAME_INVALID = 'Invalid';

    private static self $v4;

    private static self $v6;

    private static self $invalid;

    private string $name;

    private int $octets;

    private int $maxPrefix;

    private function __construct(
        string $name,
        int $octets,
        int $maxPrefix
    ) {
        $this->name = $name;
        $this->octets = $octets;
        $this->maxPrefix = $maxPrefix;
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public static function v4(): self
    {
        return self::$v4 ?? (self::$v4 = new self(self::NAME_V4, 4, 32));
    }

    public static function v6(): self
    {
        return self::$v6 ?? (self::$v6 = new self(self::NAME_V6, 16, 128));
    }

    public static function invalid(): self
    {
        return self::$invalid ?? (self::$invalid = new self(self::NAME_INVALID, 0, 0));
    }

    public function name(): string
    {
        return $this->name;
    }

    public function octets(): int
    {
        return $this->octets;
    }

    public function maxPrefix(): int
    {
        return $this->maxPrefix;
    }
}
