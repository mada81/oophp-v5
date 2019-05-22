<?php

namespace Anax\View;

if (!$resultset) {
    return;
}
?>

<table>
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Bild</th>
        <th>Titel (Ändra/Ta bort)</th>
        <th>År</th>
    </tr>
<?php $id = -1; foreach ($resultset as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><img class="thumb" src="../<?= $row->image ?>"></td>
        <td><a href="edit-movie/<?= $row->id ?>"><?= $row->title ?></a></td>
        <td><?= $row->year ?></td>
    </tr>
<?php endforeach; ?>
</table>
