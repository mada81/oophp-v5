<?php

/**
 * Init the game and redirect to start play game.
 */
$app->router->get("dice/init", function () use ($app) {
    // Init game session.
    $game = new Mada\Dice\Game();
    $_SESSION["cpuScore"] = 0;
    $_SESSION["cpuTurnScore"] = 0;
    $_SESSION["playerScore"] = 0;
    $_SESSION["playerTurnScore"] = 0;
    $_SESSION["activePlayer"] = "Spelare";

    return $app->response->redirect("dice/play");
});

/**
 * Play the game - Show game status.
 */
$app->router->get("dice/play", function () use ($app) {
    // Start play gmae
    $title = "Tärningsspel 100";

    // Get current settings from SESSION.
    $cpuScore = $_SESSION["cpuScore"];
    $playerScore = $_SESSION["playerScore"];
    $cpuTurnScore = $_SESSION["cpuTurnScore"] ?? 0;
    $playerTurnScore = $_SESSION["playerTurnScore"] ?? 0;
    $activePlayer = $_SESSION["activePlayer"] ?? null;
    $doInit = $_SESSION["doInit"] ?? null;
    $win = $_SESSION["win"] ?? null;
    $_SESSION["win"] = null;
    $_SESSION["doRoll"] = null;
    $_SESSION["doStay"] = null;
    $_SESSION["doNext"] = null;

    $data = [
        "cpuScore"   => $cpuScore,
        "playerScore"  => $playerScore,
        "cpuTurnScore"   => $cpuTurnScore,
        "playerTurnScore"  => $playerTurnScore,
        "activePlayer"  => $activePlayer,
        "win" => $win,
    ];

    $app->page->add("dice/play", $data);
    $app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Play the game.
 */
$app->router->post("dice/play", function () use ($app) {
    // Incomming variables.
    $doRoll = $_POST["doRoll"] ?? null;
    $doStay = $_POST["doStay"] ?? null;
    $doNext = $_POST["doNext"] ?? null;

    // Get current settings from SESSION.
    $playerScore = $_SESSION["playerScore"];
    $playerTurnScore = $_SESSION["playerTurnScore"];
    $cpuScore = $_SESSION["cpuScore"];
    $cpuTurnScore = $_SESSION["cpuTurnScore"] ?? 0;

    // Player rolls the dices.
    if ($doRoll) {
        $game = new Mada\Dice\Game($playerScore, $playerTurnScore);
        $playerTurnScore = $game->handRoll();
        $_SESSION["win"] = $game->winCondition();
        $_SESSION["playerTurnScore"] = $playerTurnScore;

        // If a 1 is rolled.
        if ($playerTurnScore == 0) {
            $_SESSION["playerTurnScore"] = 0;
            $_SESSION["activePlayer"] = "Datorn";
        }

        return $app->response->redirect("dice/play");
    }

    // Player saves turn score and passes turn to next player.
    if ($doStay) {
        $_SESSION["playerScore"] += $_SESSION["playerTurnScore"];
        $_SESSION["playerTurnScore"] = 0;
        $_SESSION["activePlayer"] = "Datorn";

        return $app->response->redirect("dice/play");
    }

    // Computers next step.
    if ($doNext) {
        $game = new Mada\Dice\Game($cpuScore, $cpuTurnScore, "Datorn");
        $stay = $game->cpuCheckScore();

        // Computer has above 20 turn score and stays.
        if ($stay == 1) {
            $_SESSION["cpuScore"] += $_SESSION["cpuTurnScore"];
            $_SESSION["cpuTurnScore"] = 0;
            $_SESSION["activePlayer"] = "Spelare";
        }

        // Computer has below 20 and keeps rolling.
        if ($stay == 0) {
            $cpuTurnScore = $game->handRoll();
            $_SESSION["win"] = $game->winCondition();
            $_SESSION["cpuTurnScore"] = $cpuTurnScore;

            // Computer rolls a 1.
            if ($cpuTurnScore == 0) {
                $_SESSION["cpuTurnScore"] = 0;
                $_SESSION["activePlayer"] = "Spelare";
            }
        }
        return $app->response->redirect("dice/play");
    }
});
