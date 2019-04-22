<?php

namespace Anax\View;

?><h1>Guess my number</h1>

<p>Guess a number between 1 and 100. You have <?= $tries ?> tries left</p>

<form method="post">
    <input type="number" name="guess" required>
    <input type="submit" name="doGuess" value="Guess">
</form>
<br>
<form method="post">
    <input type="submit" name="doInit" value="Restart game">
    <input type="submit" name="doCheat" value="Cheater?">
</form>

<?php if ($result) : ?>
    <p>The guess <?= $guess ?> is <b><?= $result ?></b></p>
<?php endif; ?>

<?php if ($doCheat) : ?>
    <p>Cheater! Current number is: <?= $number ?>.</p>
<?php endif; ?>

<?php if ($doInit) : ?>
    <p>Game restarted! New number chosen. Good luck.</p>
<?php endif; ?>

<?php if ($disq) : ?>
    <p><?= $disq ?>.</p>
<?php endif; ?>
