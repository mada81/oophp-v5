<?php

namespace Mada\Dice;

/**
 * Game class for Dice game
 */
class Game
{
    /**
     * @var int $winScore       Array containing player's score and DiceHands
     * @var bool $win           Decides if a player has met the win criteria
     * @var int $totalScore     Total score for player is taken as param
     * @var int $turnScore      Turn score for player is taken as param
     * @var string $player      Player name is taken as param
     * @var DiceHand $diceHand   DiceHand object.
     */
    private $winScore = 100;
    private $totalScore = 0;
    private $turnScore = 0;
    private $player = "";


    /**
     * Constructor to initiate a Dice. If no input for sides is given,
     * sides is set to 6 by default. Last roll will be randomized.
     *
     * @param int $totalScore     Total score for player is taken as param
     * @param int $turnScore      Turn score for player is taken as param
     * @param string $player      Player name is taken as param
     */
    public function __construct(int $totalScore = 0, int $turnScore = 0, string $player = "Spelare")
    {
        $this->totalScore = $totalScore;
        $this->turnScore = $turnScore;
        $this->player = $player;
        $this->win = false;
        $this->diceHand = new DiceHand;
    }


    /**
     * Returns value of rolled DiceHand.
     * If DiceHand includes a dice with 1, value of roll is set to 0.
     */
    public function handRoll() : int
    {
        $allValues = $this->diceHand->values();
        
        foreach ($allValues as $value) {
            if ($value == 1) {
                $this->turnScore = 0;
                break;
            }
            $this->turnScore += $value;
        }
        // if ($this->turnScore )
        return $this->turnScore;
    }


    /**
     * Check if player "Datorn" has turnScore above 20.
     * Returns 1 if true. 0 if false.
     */
    public function cpuCheckScore() : int
    {
        $stay = 0;
        if ($this->player == "Datorn" && $this->turnScore > 20) {
            $stay = 1;
        }
        return $stay;
    }


    /**
     * Check if totalScore plus turnScore is 100 or more.
     * Returns true if it is.
     */
    public function winCondition()
    {
        if ($this->totalScore + $this->turnScore >= $this->winScore) {
            $this->win = true;
        }
        return $this->win;
    }


    /**
     * Return total score.
     */
    public function getTotalScore() : int
    {
        return $this->totalScore;
    }



    /**
     * Return turn score.
     */
    public function getTurnScore() : int
    {
        return $this->turnScore;
    }



    /**
     * Return player.
     */
    public function getPlayer() : string
    {
        return $this->player;
    }
}
