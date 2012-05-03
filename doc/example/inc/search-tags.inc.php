<h2>Tag search</h2>
<? include('inc/search-meta.inc.php') ?>
<ul>
<? foreach ($drPublishApiClientSearchList as $drPublishApiClientTag) { ?>
        <li>
            <strong><?= $drPublishApiClientTag->getName() ?></strong>
             [id=<?= $drPublishApiClientTag->getId() ?>]
            <br />
            <span style="color: #666">
            Type: <?=$drPublishApiClientTag->getTagTypeName(); ?> (id=<?=$drPublishApiClientTag->getTagTypeId(); ?>)
                <br/>
            Content:  <?= htmlentities($drPublishApiClientTag->getContent()); ?>
            </span>
        </li>
<? } ?>
</ul>
<? include('inc/search-paginator.inc.php') ?>
