<? include('inc/search-meta.inc.php') ?>
<h2>Author search</h2>
<ul>
<? foreach ($drPublishApiClientSearchList as $drPublishApiClientAuthor) { ?>
    <li>
        <strong><?= $drPublishApiClientAuthor->getFullName() ?></strong>
         [id=<?= $drPublishApiClientAuthor->getId() ?>, username=<?= $drPublishApiClientAuthor->getUserName() ?>]
    </li>
<? } ?>
</ul>
<? include('inc/search-paginator.inc.php') ?>
<?= printSourceCode() ?>