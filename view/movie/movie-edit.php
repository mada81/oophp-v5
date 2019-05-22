<?php

namespace Anax\View;

?>
<navbar class="navbar">
    <!-- <a href="?route=select">SELECT *</a> | -->
    <br>
    <a href="../index">Visa alla filmer</a> |
    <!-- <a href="?route=reset">Reset database</a> | -->
    <a href="../search-title">Sök på titel</a> |
    <a href="../search-year">Sök på årtal</a> |
    <a href="../add-movie">Lägg till film</a>
<!--    <a href="?route=movie-edit">Edit</a> | -->
    <!-- <a href="?route=show-all-sort">Show all sortable</a> |
    <a href="?route=show-all-paginate">Show all paginate</a> | -->
</navbar> 

<h1>Min filmdatabas</h1>

<form method="post">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="movieId" value="<?= $resultset->id ?>"/>

    <p>
        <label>Title:<br> 
        <input type="text" name="movieTitle" value="<?= $resultset->title ?>"/>
        </label>
    </p>

    <p>
        <label>Year:<br> 
        <input type="number" name="movieYear" value="<?= $resultset->year ?>"/>
    </p>

    <p>
        <label>Image:<br> 
        <input type="text" name="movieImage" value="<?= $resultset->image ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Spara">
        <input type="reset" value="Återställ">
        <input type="submit" name="doDelete" value="Ta bort">
    </p>
    </fieldset>
</form>

