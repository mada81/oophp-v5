<?php

namespace Mada\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice
 */
class GameCreateObjectTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties. Use no arguments.
     */
    public function testCreateObjectNoArguments()
    {
        $game = new Game(56, 0, 0, 0);
        $this->assertInstanceOf("\Mada\Dice\Game", $game);

        $res = $game->getPlayerTotalScore();
        $exp = 56;
        $this->assertEquals($exp, $res);
    }



    /**
     * Construct object and verify that the object has the expected
     * properties. Use middle arguments.
     */
    public function testCreateObjectMiddleArguments()
    {
        $game = new Game(0, 38);
        $this->assertInstanceOf("\Mada\Dice\Game", $game);

        $res = $game->getPlayerTurnScore();
        $exp = 38;
        $this->assertEquals($exp, $res);
    }
}
