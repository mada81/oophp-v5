<?php

namespace Mada\Dice;

/**
 * A dicehand, consisting of dices.
 */
class DiceHand
{
    /**
    * @var Dice $dices   Array consisting of dices.
    * @var int  $values  Array consisting of last roll of the dices.
    */
    private $dices;
    private $values;


    /**
    * Constructor to initiate the dicehand with a number of dices.
    *
    * @param int $dices Number of dices to create, defaults to 2.
    */
    public function __construct(int $dices = 2)
    {
        $this->dices  = [];
        $this->values = [];

        for ($i = 0; $i < $dices; $i++) {
            $this->dices[]  = new Dice();
            $this->values[] = null;
        }
    }


    /**
    * Roll all dices.
    *
    * @return void.
    */
    private function rollDiceHand() : void
    {
        // var_dump($this->dices);
        for ($i = 0; $i < sizeof($this->dices); $i++) {
            $this->dices[$i]->roll();
        }
    }


    /**
    * Get values of dices from last roll.
    *
    * @return array with values of the last roll.
    */
    public function values() : array
    {
        for ($i = 0; $i < sizeof($this->dices); $i++) {
            $this->values[$i] = $this->dices[$i]->getLastRoll();
        }
        return $this->values;
    }
}
