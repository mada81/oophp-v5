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
