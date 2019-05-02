<?php

namespace Mada\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand
 */
class DiceHandCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $diceHand = new DiceHand();
        $this->assertInstanceOf("\Mada\Dice\DiceHand", $diceHand);

        $res = $diceHand->getNumberOfDices();
        $exp = 2;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use argument.
     */
    public function testCreateObjectArgument()
    {
        $diceHand = new DiceHand(10);
        $this->assertInstanceOf("\Mada\Dice\DiceHand", $diceHand);

        $res = $diceHand->getNumberOfDices();
        $exp = 10;

        $this->assertEquals($exp, $res);
    }
}
