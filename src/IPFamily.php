<?php

namespace Littledev\IPTools;

interface IPFamily
{
    public const IPv4 = 'IPv4';
    public const IPv6 = 'IPv6';
    public const Invalid = 'invalid';

    public const OCTET_IPv4 = 4;
    public const OCTET_IPv6 = 16;

    public const MAX_PREFIX_IPv4 = 32;
    public const MAX_PREFIX_IPv6 = 128;
}
