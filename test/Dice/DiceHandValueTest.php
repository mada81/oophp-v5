<?php

namespace Mada\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class DiceHand
 */
class DiceHandValuesTest extends TestCase
{
    /**
     * Test values. Array is expected
     */
    public function testValues()
    {
        $diceHand = new DiceHand();

        $res = $diceHand->values();
        $this->assertIsArray($res);
    }


    /**
    * Test values. Array is expected
    */
    public function testRollDiceHand()
    {
        $diceHand = new DiceHand();

        $res = $diceHand->rollDiceHand();
        $this->assertIsArray($res);
    }
}
