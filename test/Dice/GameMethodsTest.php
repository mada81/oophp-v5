<?php

namespace Mada\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice
 */
class GameMethodsTest extends TestCase
{
    /**
     * Test cpuCheckScore. Turns score is set to 18. Return shall be 0.
     */
    public function testRollHand()
    {
        $diceHand = new DiceHand;

        $res = $diceHand->rollDiceHand()[1];
        $exp = $diceHand->getDices()[1]->getLastRoll();
        $this->assertEquals($exp, $res);
    }
}
