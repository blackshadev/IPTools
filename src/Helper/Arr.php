<?php


namespace Littledev\IPTools\Helper;


class Arr
{
    public static function any(array $arr, callable $cb)
    {
        foreach ($arr as $item) {
            if ($cb($item)) {
                return true;
            }
        }
        return false;
    }

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
