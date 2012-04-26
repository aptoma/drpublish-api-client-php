<h2>Category search</h2>
<? include('inc/search-meta.inc.php') ?>
<ul>
<? foreach ($drPublishApiClientSearchList as $drpublishApiClientCategory) { ?>
        <li>
            <strong><?= $drpublishApiClientCategory->getName() ?></strong>
             [id=<?= $drpublishApiClientCategory->getId() ?>]
            <br />
            Parent category: <?=$drpublishApiClientCategory->getParentName() ?>
            <span style="color: #666">
            </span>
        </li>
<? } ?>
</ul>
<? include('inc/search-paginator.inc.php') ?>
