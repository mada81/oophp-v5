<?php

namespace Mada\Dice;

/**
 *
 * Dice class
 */
class Dice
{
    /**
     * @var int  $sides     Number of sides on dice.
     * @var int  $lastRoll  Represents last roll of dice.
     */
    public $sides = 0;
    private $lastRoll = null;

    /**
     * Constructor for dice
     *
     * @var int sides is number of sides on the dice.
     */
    public function __construct($sides = 6)
    {
        $this->sides = $sides;
    }
    
    /**
     * Roll one die
     *
     * @return void value of dice roll.
     */
    public function roll()
    {
        $this->lastRoll = rand(1, 6);
        return $this->lastRoll;
    }

    /**
     * Return value of dice.
     *
     * @return int value of lastRoll
     */
    public function getLastRoll()
    {
        return $this->lastRoll;
    }
}
