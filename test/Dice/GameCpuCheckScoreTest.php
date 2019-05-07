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
        $game = new Game(20, 0, 20, 18);

        $res = $game->cpuCheckScore();
        $exp = false;
        $this->assertEquals($exp, $res);
    }


    /**
     * Test cpuCheckScore. Turns score is set to 25. Return shall be 1.
     */
    public function testCpuCheckScoreHigh()
    {
        $game = new Game(20, 0, 20, 25);

        $res = $game->cpuCheckScore();
        $exp = true;
        $this->assertEquals($exp, $res);
    }
    
    
    /**
     * Test cpuCheckScore. Player score is 90. Cpu should keep rolling. Expecting "false".
     */
    public function testCpuCheckScorePlayerHigh()
    {
        $game = new Game(90, 0, 20, 25);
        
        $res = $game->cpuCheckScore();
        $exp = false;
        $this->assertEquals($exp, $res);
    }
}
