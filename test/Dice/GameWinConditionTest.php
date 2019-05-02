<?php

namespace Mada\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice
 */
class GameWinConditionTest extends TestCase
{
    /**
     * Test winCondition. Total score + turn score < 100
     */
    public function testWinConditionFalse()
    {
        $game = new Game(50, 40);

        $res = $game->winCondition();
        $exp = false;
        $this->assertEquals($exp, $res);
    }


    /**
     * Test winCondition. Total score + turn score > 100
     */
    public function testWinConditionTrue()
    {
        $game = new Game(50, 55);

        $res = $game->winCondition();
        $exp = true;
        $this->assertEquals($exp, $res);
    }
}
