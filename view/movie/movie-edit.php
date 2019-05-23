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

