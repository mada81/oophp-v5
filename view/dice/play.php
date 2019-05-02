<?php

namespace Anax\View;

?><h1>Tärningsspel 100</h1>


<?php if ($activePlayer) : ?>
    <p>Aktiv spelare: <b><?= $activePlayer ?></b></p>
<?php endif; ?>


<table>
    <tr>
        <th style="width:33%">Deltagare</th>
        <th style="width:33%">Total poäng</th> 
        <th style="width:33%">Poäng denna rundan</th>
    </tr>
    <tr style="width:33%">
        <td>Datorn</td>
        <td><?= $cpuScore ?></td> 
        <td><?= $cpuTurnScore ?></td> 
    </tr>
    <tr style="width:33%">
        <td>Spelare</td>
        <td><?= $playerScore ?></td> 
        <td><?= $playerTurnScore ?></td>
  </tr>
</table>
<br>
<form method="post">
    <input type="submit" <?php if ($activePlayer == "Datorn" || $win == true) : ?>
    <?= "disabled" ?>
    <?php endif; ?> name="doRoll" value="Kasta tärningarna">

    <input type="submit" <?php if ($activePlayer == "Datorn" || $win == true) : ?>
    <?= "disabled" ?>
    <?php endif; ?> name="doStay" value="Stanna och spara">
    <br>
    <br>
    <input type="submit" <?php if ($activePlayer == "Spelare" || $win == true) : ?>
    <?= "disabled" ?>
    <?php endif; ?> name="doNext" value="Datorns nästa drag">
</form>
<br>

<a href=dice-game>
    <button>Starta om spelet</button>
</a>

<br>

<?php if ($win == true) : ?>
    <p><b>Spelet över. Vinnare är: <?= $activePlayer ?></b></p>
<?php endif; ?>


<!-- <form method="post">
    <input type="submit" name="doInit" value="Restart game">
    <input type="submit" name="doCheat" value="Cheater?">
</form> -->

<!-- <div class="board">
    <div class="players">
        <div class="cpu">Datorn: </div>
        <div class="player">Spelare: </div>
    </div>
    <div class="score">
        <div class="cpu-score"></div>
        <div class="player-score"></div>
    </div>
    <div class="turn-score">
        <div class="cpu-turn-score"></div>
        <div class="player-turn-score"></div>
    </div>
</div> -->


