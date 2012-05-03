<h2>Sources search</h2>
<? include('inc/search-meta.inc.php') ?>
<br/>
<ul>
<? foreach ($drPublishApiClientSearchList as $drPublishApiClientSource) { ?>
        <li>
            <strong><?= $drPublishApiClientSource->getName() ?></strong>
             [id=<?= $drPublishApiClientSource->getId() ?>]
            <br />
            <span style="color: #666">
            </span>
        </li>
<? } ?>
</ul>
<? include('inc/search-paginator.inc.php') ?>
