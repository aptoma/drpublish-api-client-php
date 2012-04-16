<h2>Author search</h2>
<ul>
<? foreach ($drpublishApiClientAuthors as $drpublishApiClientAuthor) { ?>
        <li>
            <strong><?= $drpublishApiClientAuthor->getFullName() ?></strong>
             [id=<?= $drpublishApiClientAuthor->getId() ?>, username=<?= $drpublishApiClientAuthor->getUserName() ?>]
        </li>
<? } ?>
</ul>