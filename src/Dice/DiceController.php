<?php

namespace Mada\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A game controller for Dice.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
        return $this->app->response->redirect("dice-game");
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function initAction() : object
    {
        // Init game session.
        $game = new Game();
        $_SESSION["cpuTotalScore"] = 0;
        $_SESSION["cpuTurnScore"] = 0;
        $_SESSION["playerTotalScore"] = 0;
        $_SESSION["playerTurnScore"] = 0;
        $_SESSION["activePlayer"] = "Spelare";
        $_SESSION["class"] = null;


        return $this->app->response->redirect("dice1/play");
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionGet() : object
    {
        // Start play gmae
        $title = "Tärningsspel 100 (1)";

        // Get current settings from SESSION.
        $cpuTotalScore = $_SESSION["cpuTotalScore"];
        $playerTotalScore = $_SESSION["playerTotalScore"];
        $cpuTurnScore = $_SESSION["cpuTurnScore"] ?? 0;
        $playerTurnScore = $_SESSION["playerTurnScore"] ?? 0;
        $activePlayer = $_SESSION["activePlayer"] ?? null;
        $doInit = $_SESSION["doInit"] ?? null;
        $win = $_SESSION["win"] ?? null;
        $class = $_SESSION["class"] ?? null;
        $res = $_SESSION["res"] ?? null;

        $_SESSION["win"] = null;
        $_SESSION["doRoll"] = null;
        $_SESSION["doStay"] = null;
        $_SESSION["doNext"] = null;

        $data = [
            "cpuTotalScore"   => $cpuTotalScore,
            "playerTotalScore"  => $playerTotalScore,
            "cpuTurnScore"   => $cpuTurnScore,
            "playerTurnScore"  => $playerTurnScore,
            "activePlayer"  => $activePlayer,
            "win" => $win,
            "class" => $class,
            "res" => $res,
        ];

        $this->app->page->add("dice1/play", $data);
        $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }


        /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function playActionPost() : object
    {
        // Incomming variables.
        $doRoll = $_POST["doRoll"] ?? null;
        $doStay = $_POST["doStay"] ?? null;
        $doNext = $_POST["doNext"] ?? null;

        // Player rolls the dices.
        if ($doRoll) {
            return $this->app->response->redirect("dice1/roll");
        }
            // Player saves turn score and passes turn to next player.
        if ($doStay) {
            return $this->app->response->redirect("dice1/stay");
        }
        // Computers next step.
        if ($doNext) {
            return $this->app->response->redirect("dice1/next");
        }
    }


        /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function rollAction() : object
    {
        // Get current settings from SESSION.
        $playerTotalScore = $_SESSION["playerTotalScore"];
        $playerTurnScore = $_SESSION["playerTurnScore"];
        $game = new Game($playerTotalScore, $playerTurnScore);
        $res = $game->rollHand();
        $playerTurnScore = $game->playerRoll($res);
        $class = $game->getValues();
        $_SESSION["res"] = $res;
        $_SESSION["class"] = $class;
        $_SESSION["win"] = $game->didIWin($playerTotalScore, $playerTurnScore);
        $_SESSION["playerTurnScore"] = $playerTurnScore;

        // If a 1 is rolled.
        if ($playerTurnScore == 0) {
            $_SESSION["playerTurnScore"] = 0;
            $_SESSION["activePlayer"] = "Datorn";
        }

        return $this->app->response->redirect("dice1/play");
    }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function stayAction() : object
    {
        $_SESSION["playerTotalScore"] += $_SESSION["playerTurnScore"];
        $_SESSION["playerTurnScore"] = 0;
        $_SESSION["activePlayer"] = "Datorn";

        return $this->app->response->redirect("dice1/play");
    }



    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function nextAction() : object
    {
        $cpuTotalScore = $_SESSION["cpuTotalScore"];
        $playerTotalScore = $_SESSION["playerTotalScore"];
        $cpuTurnScore = $_SESSION["cpuTurnScore"] ?? 0;
        $game = new Game($playerTotalScore, 0, $cpuTotalScore, $cpuTurnScore);
        $stay = $game->cpuCheckScore();

        // Computer has above 20 turn score and stays.
        if ($stay == 1) {
            $_SESSION["cpuTotalScore"] += $_SESSION["cpuTurnScore"];
            $_SESSION["cpuTurnScore"] = 0;
            $_SESSION["activePlayer"] = "Spelare";
        }

        // Computer has below 20 and keeps rolling.
        if ($stay == 0) {
            $res = $game->rollHand();
            $cpuTurnScore = $game->cpuRoll($res);
            $class = $game->getValues();
            $_SESSION["res"] = $res;
            $_SESSION["class"] = $class;
            $_SESSION["win"] = $game->didIWin($cpuTotalScore, $cpuTurnScore);
            $_SESSION["cpuTurnScore"] = $cpuTurnScore;

            // Computer rolls a 1.
            if ($cpuTurnScore == 0) {
                $_SESSION["cpuTurnScore"] = 0;
                $_SESSION["activePlayer"] = "Spelare";
            }
        }
        return $this->app->response->redirect("dice1/play");
    }
}
