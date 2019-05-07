<?php

namespace Mada\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice
 */
class GameDidIWinTest extends TestCase
{
    /**
     * Test didIWin. Total score + turn score < 100
     */
    public function testDidIWinFalse()
    {
        $game = new Game();

        $res = $game->didIWin(40, 50);
        $exp = false;
        $this->assertEquals($exp, $res);
    }


    /**
     * Test didIWin. Total score + turn score > 100
     */
    public function testDidIWinTrue()
    {
        $game = new Game();

        $res = $game->didIWin(40, 70);
        $exp = true;
        $this->assertEquals($exp, $res);
    }
}
