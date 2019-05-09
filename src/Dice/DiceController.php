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
        $session = $this->app->session;
        $response = $this->app->response;

        // Init game session.
        // $game = new Game();
        $session->set("cpuTotalScore", 0);
        $session->set("cpuTurnScore", 0);
        $session->set("playerTotalScore", 0);
        $session->set("playerTurnScore", 0);
        $session->set("activePlayer", "Spelare");
        $session->set("class", null);
        $session->set("histogram", null);

        return $response->redirect("dice1/play");
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
        $page = $this->app->page;
        $session = $this->app->session;

        // Start play gmae
        $title = "Tärningsspel 100 (Controller)";

        // Get current settings from SESSION.
        $cpuTotalScore = $session->get("cpuTotalScore");
        $playerTotalScore = $session->get("playerTotalScore");
        $cpuTurnScore = $session->get("cpuTurnScore", 0);
        $playerTurnScore = $session->get("playerTurnScore", 0);
        $activePlayer = $session->get("activePlayer");
        $doInit = $session->get("doInit");
        $win = $session->get("win");
        $class = $session->get("class");
        $res = $session->get("res");
        $histogram = $session->get("histogram");

        // Set varables in session
        $session->set("win", null);
        $session->set("doRoll", null);
        $session->set("doStay", null);
        $session->set("doNext", null);

        $data = [
            "cpuTotalScore"   => $cpuTotalScore,
            "playerTotalScore"  => $playerTotalScore,
            "cpuTurnScore"   => $cpuTurnScore,
            "playerTurnScore"  => $playerTurnScore,
            "activePlayer"  => $activePlayer,
            "win" => $win,
            "class" => $class,
            "res" => $res,
            "histogram" => $histogram,
        ];

        $page->add("dice1/play", $data);
        $page->add("dice1/debug");

        return $page->render([
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
        $request = $this->app->request;
        $response = $this->app->response;

        // Incomming variables.
        $doRoll = $request->getPost("doRoll");
        $doStay = $request->getPost("doStay");
        $doNext = $request->getPost("doNext");

        // Player rolls the dices.
        if ($doRoll) {
            return $response->redirect("dice1/roll");
        }
            // Player saves turn score and passes turn to next player.
        if ($doStay) {
            return $response->redirect("dice1/stay");
        }
        // Computers next step.
        if ($doNext) {
            return $response->redirect("dice1/next");
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
        $response = $this->app->response;
        $session = $this->app->session;

        // Get current settings from SESSION.
        $playerTotalScore = $session->get("playerTotalScore");
        $playerTurnScore = $session->get("playerTurnScore");

        $game = new Game($playerTotalScore, $playerTurnScore);
        // FUNKAR
        $res = $game->rollHand();
        // $res = $game->rollHand();
        // $res = $game->rollHand();
        // $res = $game->rollHand();
        echo($res);
        // FUNKAR
        $playerTurnScore = $game->playerRoll($res);
        $class = $game->getValues();
        $histogram = $session->get("histogram", new Histogram());
        $histogram->addSerie($res[0]);
        $histogram->addSerie($res[1]);
        $session->set("histogram", $histogram);
        $session->set("res", $res);
        $session->set("class", $class);
        $session->set("win", $game->didIWin($playerTotalScore, $playerTurnScore));
        $session->set("playerTurnScore", $playerTurnScore);

        // If a 1 is rolled.
        if ($playerTurnScore == 0) {
            $session->set("playerTurnScore", 0);
            $session->set("activePlayer", "Datorn");
        }

        return $response->redirect("dice1/play");
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
        $response = $this->app->response;
        $session = $this->app->session;

        $session->set("playerTotalScore", $session->get("playerTotalScore") + $session->get("playerTurnScore"));
        $session->set("playerTurnScore", 0);
        $session->set("activePlayer", "Datorn");

        return $response->redirect("dice1/play");
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
        $response = $this->app->response;
        $session = $this->app->session;

        $cpuTotalScore = $session->get("cpuTotalScore");
        $playerTotalScore = $session->get("playerTotalScore");
        $cpuTurnScore = $session->get("cpuTurnScore", 0);

        $game = new Game($playerTotalScore, 0, $cpuTotalScore, $cpuTurnScore);
        $stay = $game->cpuCheckScore();



        

        // Computer has above 20 turn score and stays.
        if ($stay == 1) {
            $session->set("cpuTotalScore", $session->get("cpuTotalScore") + $session->get("cpuTurnScore"));
            $session->set("cpuTurnScore", 0);
            $session->set("activePlayer", "Spelare");
        }

        // Computer has below 20 and keeps rolling.
        if ($stay == 0) {
            $res = $game->rollHand();

            $histogram = $session->get("histogram", new Histogram());
            $histogram->addSerie($res[0]);
            $histogram->addSerie($res[1]);
            $session->set("histogram", $histogram);

            $cpuTurnScore = $game->cpuRoll($res);
            $class = $game->getValues();
            $session->set("res", $res);
            $session->set("class", $class);
            $session->set("win", $game->didIWin($cpuTotalScore, $cpuTurnScore));
            $session->set("cpuTurnScore", $cpuTurnScore);

            // Computer rolls a 1.
            if ($cpuTurnScore == 0) {
                $session->set("cpuTurnScore", 0);
                $session->set("activePlayer", "Spelare");
            }
        }
        return $response->redirect("dice1/play");
    }
}
