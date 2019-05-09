<?php

namespace Mada\Dice;

/**
 *
 * A graphic dice.
 */
class DiceGraphic extends Dice implements HistogramInterface
{
    use HistogramTrait;

    /**
     * @var integer SIDES Number of sides of the Dice.
     */
    const SIDES = 6;

    /**
     * Constructor to initiate the dice with six number of sides.
     */
    public function __construct()
    {
        parent::__construct(self::SIDES);
    }

    /**
     * Get a graphic value of the last rolled dice.
     *
     * @return string as graphical representation of last rolled dice.
     */
    public function graphic()
    {
        return "dice-" . $this->getLastRoll();
    }


    // /**
    // * Get max value for the histogram.
    // *
    // * @return int with the max value.
    // */
    // public function getHistogramMax()
    // {
    //     return $this->sides;
    // }



    /**
    * Roll the dice, remember its value in the serie and return
    * its value.
    *
    * @return int the value of the rolled dice.
    */
    public function roll()
    {
        $this->serie[] = parent::roll();
        return $this->getLastRoll();
    }
}
