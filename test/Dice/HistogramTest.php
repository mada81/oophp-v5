<?php

namespace Mada\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Guess.
 */
class HistogramTest extends TestCase
{
    /**
     * Test roll method. Last Roll should be random from 1 to 6.
     */
    public function testHistogramSerie()
    {
        $histogram = new Histogram();

        $histogram->addSerie(7);
        $res = $histogram->getSerie();
        $exp = [7];
        $this->assertEquals($exp, $res);
    }



    /**
    * Test roll method. Last Roll should be random from 1 to 6.
    */
    public function testHistogramMin()
    {
        $dice = new DiceGraphic();
        $res = $dice->getHistogramMin();
        $exp = 1;
        $this->assertEquals($exp, $res);
    }

    /**
    * Test roll method. Last Roll should be random from 1 to 6.
    */
    public function testGetAsTesxt()
    {
        $histogram = new Histogram();
        $res = $histogram->getAsText();
        $exp = "";
        $this->assertNotEquals($exp, $res);
    }
}
