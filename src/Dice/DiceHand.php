<?php

namespace Mada\Dice;

/**
 * A dicehand, consisting of dices.
 */
class DiceHand
{
    /**
    * @var DiceGraphic $dices   Array consisting of dices.
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
            $this->dices[]  = new DiceGraphic();
            $this->values[] = null;
        }
    }


    /**
    * Roll all dices.
    *
    * @return void.
    */
    public function rollDiceHand() : array
    {
        $temp = [];
        for ($i = 0; $i < sizeof($this->dices); $i++) {
            $temp[] = $this->dices[$i]->roll();
        }
        return $temp;
    }

    public function getDices()
    {
        return $this->dices;
    }


    /**
    * Get values of dices from last roll.
    *
    * @return array with values of the last roll.
    */
    public function values() : array
    {
        for ($i = 0; $i < sizeof($this->dices); $i++) {
            $grapfDices[] = $this->dices[$i]->graphic();
        }
        return $grapfDices;
    }


    /**
     * Get number of dices.
     *
     * @return int number of dices..
    */
    public function getNumberOfDices() : int
    {
        return sizeof($this->dices);
    }
}
