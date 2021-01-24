<?php

declare(strict_types=1);


namespace Littledev\IPTools\Helper;

class Arr
{
    public static function all(array $arr, \Closure $cb)
    {
        foreach ($arr as $item) {
            if (!$cb($item)) {
                return false;
            }
        }
        return true;
    }
}
