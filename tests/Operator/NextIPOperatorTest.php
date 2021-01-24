<?php

use \PHPUnit\Framework\TestCase;
use Littledev\IPTools\Operator\NextIPOperator;
use Littledev\IPTools\Address;

class NextIPOperatorTest extends TestCase {

    protected NextIPOperator $operator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->operator = new NextIPOperator();
    }

    /**
     * @dataProvider nextIPDataProvider
     */
    public function testItWorks($ip, $next)
    {
        $nextIp = $this->operator->execute(Address::parse($ip));
        self::assertEquals((string)$next, (string)$nextIp);
    }

    public function nextIPDataProvider(): Generator
    {
        yield [ '127.0.0.1', '127.0.0.2' ];
        yield [ '127.0.0.255', '127.0.1.0' ];
        yield [ '127.0.0.255', '127.0.1.0' ];
        yield [ '2001:db8::42', '2001:db8::43' ];
        yield [ '2001:db8::ff', '2001:db8::100' ];
        yield [ '2001:db8::ffff', '2001:db8::1:0' ];

    }
}
