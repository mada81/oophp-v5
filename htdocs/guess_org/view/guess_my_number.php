<!-- View for guess my number game. -->
<h1>Guess my number</h1>

<p>Guess a number between 1 and 100. You have <?= $tries ?> tries left</p>

<form method="post">
    <input type="number" name="guess" require>
    <input type="submit" name="doGuess" value="Guess">
    <input type="submit" name="doInit" value="Restart game">
    <input type="submit" name="doCheat" value="Cheater?">
</form>

<?php if ($doGuess) : ?>
    <p>The guess <?= $guess ?> is <b><?= $result ?></b></p>
<?php endif; ?>

<?php if ($doCheat) : ?>
    <p>Cheater! Current number is: <?= $number ?>.</p>
<?php endif; ?>
