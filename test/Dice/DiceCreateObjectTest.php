<?php

namespace Mada\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice
 */
class DiceCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $dice = new Dice();
        $this->assertInstanceOf("\Mada\Dice\Dice", $dice);

        $res = $dice->sides();
        $exp = 6;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use argument.
     */
    public function testCreateObjectArgument()
    {
        $dice = new Dice(10);
        $this->assertInstanceOf("\Mada\Dice\Dice", $dice);

        $res = $dice->sides();
        $exp = 10;

        $this->assertEquals($exp, $res);
    }
}
