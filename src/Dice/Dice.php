<?php

namespace Mada\Dice;

/**
 * Dice objects will populate DiceHand object. 
 */
class Dice
{
    /**
     * @var int $sides      Number of sides on the dice.
     * @var int $lastRoll   Represents last roll of dice.
     */
     private $sides = 6;
     private $lastRoll = null;


    /**
     * Constructor to initiate a Dice. If no input for sides is given,
     * sides is set to 6 by default. Last roll will be randomized.
     *
     * @param int $sides     Will be set to 6 if no number of sides is given 
     */
    public function __construct(int $sides = 6)
    {
        $this->sides = $sides;
        $this->lastRoll = rand(1, $sides);
    }


    /**
     * Dice is rolled. Random value is set as lostRoll.
     *
     * @return int value of dice roll.
     */
    public function roll() : int
    {
        $this->lastRoll = rand(1, $sides);
        return $this->lastRoll;
    }


    /**
     * Get value of lastRoll.
     *
     * @return int value of lastRoll.
     */
    public function getLastRoll() : int
    {
        return $this->lastRoll;
    }
}
