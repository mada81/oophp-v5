<?php

namespace Mada\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice
 */
class GameCpuCheckScoreTest extends TestCase
{
    /**
     * Test cpuCheckScore. Turns score is set to 18. Return shall be 0.
     */
    public function testCpuCheckScoreLow()
    {
        $game = new Game(0, 18, "Datorn");

        $res = $game->cpuCheckScore();
        $exp = 0;
        $this->assertEquals($exp, $res);
    }


    /**
     * Test cpuCheckScore. Turns score is set to 25. Return shall be 1.
     */
    public function testCpuCheckScoreHigh()
    {
        $game = new Game(0, 25, "Datorn");

        $res = $game->cpuCheckScore();
        $exp = 1;
        $this->assertEquals($exp, $res);
    }
}
