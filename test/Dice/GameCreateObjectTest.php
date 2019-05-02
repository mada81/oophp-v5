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
        $game = new Game();
        $this->assertInstanceOf("\Mada\Dice\Game", $game);

        $res = $game->getTotalScore();
        $exp = 0;
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

        $res = $game->getTurnScore();
        $exp = 38;
        $this->assertEquals($exp, $res);
    }


    /**
     * Construct object and verify that the object has the expected
     * properties. Use last arguments.
     */
    public function testCreateObjectLastArguments()
    {
        $game = new Game(0, 38, "Janne");
        $this->assertInstanceOf("\Mada\Dice\Game", $game);

        $res = $game->getPlayer();
        $exp = "Janne";
        $this->assertEquals($exp, $res);
    }
}
