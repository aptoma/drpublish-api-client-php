<h2>Category search</h2>
<? include('inc/search-meta.inc.php') ?>
<ul>
<? foreach ($drPublishApiClientSearchList as $drpublishApiClientDossier) { ?>
        <li>
            <strong><?= $drpublishApiClientDossier->getName() ?></strong>
             [id=<?= $drpublishApiClientDossier->getId() ?>]
            <br />
            <span style="color: #666">
            </span>
        </li>
<? } ?>
</ul>
