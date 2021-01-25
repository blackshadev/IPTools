<?php

declare(strict_types=1);

use Littledev\IPTools\Helper\Arr;
use PHPUnit\Framework\TestCase;

class ArrTest extends TestCase
{
    /**
     * @dataProvider boolArrayProvider
     */
    public function testItArrAll($arr, $expected)
    {
        $output = Arr::all($arr, function ($i) {return $i;});
        self::assertEquals($expected, $output);
    }

    public function boolArrayProvider(): Generator
    {
        yield [ [true, true], true ];
        yield [ [true, false], false ];
        yield [ [], true ];
    }
}
