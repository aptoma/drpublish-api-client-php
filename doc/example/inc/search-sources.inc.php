<h2>Category search</h2>
<? include('inc/search-meta.inc.php') ?>
<ul>
<? foreach ($drPublishApiClientSearchList as $drpublishApiClientSource) { ?>
        <li>
            <strong><?= $drpublishApiClientSource->getName() ?></strong>
             [id=<?= $drpublishApiClientSource->getId() ?>]
            <br />
            <span style="color: #666">
            </span>
        </li>
<? } ?>
</ul>
