<?php

include(__DIR__ . "/autoload.php");
include(__DIR__ . "/config.php");
include(__DIR__ . "/functions.php");

// echo "<pre>";
// var_dump ($_SESSION);
// echo "</pre>";

// Start a named session
session_name("madagame");
session_start();


$guess   = $_POST["guess"]   ?? null;
$doInit  = $_POST["doInit"]  ?? null;
$doCheat = $_POST["doCheat"] ?? null;
$doGuess = $_POST["doGuess"] ?? null;

//Get current settings from SESSION.
$number  = $_SESSION["number"] ?? null;
$tries   = $_SESSION["tries"]  ?? null;
$game = null;

if ($doInit || $number === null) {
    // Init the game
    $game = new Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
} elseif ($doGuess) {
    // Guess button pressed
    $game = new Guess($number, $tries);
    $result = $game->makeGuess($guess);
    $_SESSION["tries"] = $game->tries();
    // if ($guess == $number) {
    //     destroy();
    //     // header("Location: index.php");
    // }
    // echo $result;
} elseif (isset($doCheat)) {
    echo "Secret number is: " . $number;
}

require __DIR__ . "/view/guess_my_number.php";
