<?php


namespace Littledev\IPTools\Helpers;


class Arr
{
    public static function any(array $arr, callable $cb)
    {
        foreach ($arr as $item) {
            if ($cb) {
                return true;
            }
        }
        return false;
    }
}
