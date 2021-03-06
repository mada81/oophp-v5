<?php

namespace Mada\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class DiceGraphicRollTest extends TestCase
{
    /**
     * Test roll method. Last Roll should be random from 1 to 6.
     */
    public function testGetLastRoll()
    {
        $dice = new DiceGraphic();

        $dice->roll();
        $res = $dice->getHistogramSerie()[0];
        $exp = $dice->getLastRoll();
        $this->assertEquals($exp, $res);
    }
}
