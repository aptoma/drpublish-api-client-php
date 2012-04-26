<? include('inc/search-meta.inc.php') ?>
<h2>Author search</h2>
<ul>
<? foreach ($drPublishApiClientSearchList as $drpublishApiClientAuthor) { ?>
        <li>
            <strong><?= $drpublishApiClientAuthor->getFullName() ?></strong>
             [id=<?= $drpublishApiClientAuthor->getId() ?>, username=<?= $drpublishApiClientAuthor->getUserName() ?>]
        </li>
<? } ?>
</ul>
<? include('inc/search-paginator.inc.php') ?>