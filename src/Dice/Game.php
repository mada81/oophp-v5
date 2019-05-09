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
    private $playerTotalScore = 0;
    private $playerTurnScore = 0;
    private $cpuTotalScore = 0;
    private $cpuTurnScore = 0;



    /**
     * Constructor to initiate a Dice. If no input for sides is given,
     * sides is set to 6 by default. Last roll will be randomized.
     *
     * @param int $totalScore     Total score for player is taken as param
     * @param int $turnScore      Turn score for player is taken as param
     * @param string $player      Player name is taken as param
     */
    public function __construct(int $playerTotalScore = 0, int $playerTurnScore = 0, int $cpuTotalScore = 0, int $cpuTurnScore = 0)
    {
        $this->playerTotalScore = $playerTotalScore;
        $this->playerTurnScore = $playerTurnScore;
        $this->cpuTotalScore = $cpuTotalScore;
        $this->cpuTurnScore = $cpuTurnScore;
        $this->diceHand = new DiceHand;
    }


    /**
     * Returns value of rolled DiceHand.
     * If DiceHand includes a dice with 1, value of roll is set to 0.
     */
    public function rollHand() : array
    {
        return $this->diceHand->rollDiceHand();
    }



    /**
    * Returns value of rolled DiceHand.
    * If DiceHand includes a dice with 1, value of roll is set to 0.
    */
    public function getDiceHand()
    {
        return $this->diceHand->getDices();
    }



    /**
     * Returns value of rolled DiceHand.
     * If DiceHand includes a dice with 1, value of roll is set to 0.
     */
    public function getValues() : array
    {
        $allValues = $this->diceHand->values();
        echo ("<pre>");
        var_dump($allValues);
        echo ("</pre>");

        // if ($this->turnScore )
        return $allValues;
    }

    public function playerRoll($handValue) : int
    {
        foreach ($handValue as $value) {
            if ($value == 1) {
                $this->playerTurnScore = 0;
                break;
            }
            $this->playerTurnScore += $value;
        }
        return $this->playerTurnScore;
    }


    public function cpuRoll($handValue) : int
    {
        foreach ($handValue as $value) {
            if ($value == 1) {
                $this->cpuTurnScore = 0;
                break;
            }
            $this->cpuTurnScore += $value;
        }
        return $this->cpuTurnScore;
    }



    /**
     * Check if player "Datorn" has turnScore above 20.
     * Returns 1 if true. 0 if false.
     */
    public function cpuCheckScore()
    {
        $stay = false;
        if ($this->cpuTurnScore > 20) {
            $stay = true;
            if ($this->playerTotalScore > 87) {
                $stay = false;
            }
        }
        return $stay;
    }


    /**
     * Check if totalScore plus turnScore is 100 or more.
     * Returns true if it is.
     */
    public function didIWin($total, $turn)
    {
        $win = false;
        if ($total + $turn >= $this->winScore) {
            $win = true;
        }
        return $win;
    }


    /**
     * Return total score.
     */
    public function getPlayerTotalScore() : int
    {
        return $this->playerTotalScore;
    }



    /**
     * Return turn score.
     */
    public function getPlayerTurnScore() : int
    {
        return $this->playerTurnScore;
    }
}
