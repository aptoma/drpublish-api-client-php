<h2>Sources search</h2>
<? include('inc/search-meta.inc.php') ?>
<br/>
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
<? include('inc/search-paginator.inc.php') ?>
