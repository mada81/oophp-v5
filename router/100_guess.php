<?php

/**
 * Init the game and redirect to start play game.
 */
$app->router->get("guess/init", function () use ($app) {
    // Init game session.
    $game = new Mada\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();

    return $app->response->redirect("guess/play");
});

/**
 * Play the game - Show game status.
 */
$app->router->get("guess/play", function () use ($app) {
    // Start play gmae
    $title = "Play the game";

    //Get current settings from SESSION.
    $number  = $_SESSION["number"]  ?? null;
    $tries  = $_SESSION["tries"]  ?? null;
    $result = $_SESSION["result"] ?? null;
    $guess = $_SESSION["guess"] ?? null;
    $disq = $_SESSION["disq"] ?? null;
    $doInit = $_SESSION["doInit"] ?? null;
    $doCheat = $_SESSION["doCheat"] ?? null;
    $_SESSION["result"] = null;
    $_SESSION["guess"] = null;
    $_SESSION["disq"] = null;
    $_SESSION["doInit"] = null;
    $_SESSION["doCheat"] = null;

    $data = [
        "guess"   => $guess ?? null,
        "result"  => $result,
        "tries"   => $tries,
        "number"  => $number ?? null,
        "doGuess" => $doGuess ?? null,
        "doCheat" => $doCheat,
        "doInit"  => $doInit,
        "disq"    => $disq ?? null,
    ];

    $app->page->add("guess/play", $data);
    $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});


/**
 * Play the game - make a guess.
 */
$app->router->post("guess/play", function () use ($app) {
    // Restart game.
    // Incomming variables.
    $guess   = $_POST["guess"]   ?? null;
    $doGuess = $_POST["doGuess"] ?? null;
    $doInit = $_POST["doInit"] ?? null;
    $doCheat = $_POST["doCheat"] ?? null;
    
    if ($doInit) {
        // Restart the game using restart button.
        $_SESSION["doInit"] = "doInit";
        return $app->response->redirect("guess/init");
    }

    if ($doCheat) {
        // Cheat by getting secret number.
        $_SESSION["doCheat"] = "doCheat";
        return $app->response->redirect("guess/play");
    }

    //Get current settings from SESSION.
    $number  = $_SESSION["number"] ?? null;
    $tries   = $_SESSION["tries"]  ?? null;

    if ($doGuess) {
        // Guess button pressed
        $game = new Mada\Guess\Guess($number, $tries);
        try {
            $result = $game->makeGuess($guess);
            $_SESSION["tries"] = $game->tries();
            $_SESSION["result"] = $result;
            $_SESSION["guess"] = $guess;
        } catch (Mada\Guess\GuessException $e) {
            $_SESSION["disq"] = "You need to reed the instruction. 1 <= GUESS => 100";
            // return $app->response->redirect("guess/play");
        }
        return $app->response->redirect("guess/play");
    }
});
