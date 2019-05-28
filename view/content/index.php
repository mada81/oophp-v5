<?php

namespace Anax\View;

if (!$resultset) {
    return;
}
?>

<table>
    <tr class="first">
        <th>Id</th>
        <th>Titel</th>
        <th>Publicerad</th>
        <th>Skapad</th>
        <th>Uppdaterad</th>
        <th>Borttagen</th>
        <th>Typ</th>
        <th>Path</th>
        <th>Slug</th>
    </tr>
<?php foreach ($resultset as $row) :?>
    <tr>
        <td><?= $row->id ?></td>
        <!-- <td><a href="edit-content/<?= $row->id ?>"><?= $row->title ?></a></td> -->
        <td><?= $row->title ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->path ?></td>
        <td><?= $row->slug ?></td>
    </tr>
<?php endforeach; ?>
</table>
