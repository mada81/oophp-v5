<?php
namespace Anax\View;

if (!$content) {
    return;
}
?>

<article>

<?php foreach ($content as $row) : ?>
<section>
    <header>
        <h1><a href="<?= url("content/blogpost/$row->id") ?>"><?= esc($row->title) ?></a></h1>
        <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
    </header>
    <?= esc($row->data) ?>
</section>
<?php endforeach; ?>

</article>
