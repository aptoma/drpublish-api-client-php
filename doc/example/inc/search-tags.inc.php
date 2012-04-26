<h2>Tag search</h2>
<? include('inc/search-meta.inc.php') ?>
<ul>
<? foreach ($drPublishApiClientSearchList as $drpublishApiClientTag) { ?>
        <li>
            <strong><?= $drpublishApiClientTag->getName() ?></strong>
             [id=<?= $drpublishApiClientTag->getId() ?>]
            <br />
            <span style="color: #666">
            Type: <?=$drpublishApiClientTag->getTagTypeName(); ?> (id=<?=$drpublishApiClientTag->getTagTypeId(); ?>)
                <br/>
            Content:  <?= htmlentities($drpublishApiClientTag->getContent()); ?>
            </span>
        </li>
<? } ?>
</ul>
<? include('inc/search-paginator.inc.php') ?>
