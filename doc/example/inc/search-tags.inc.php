<h2>Author search</h2>
<ul>
<? foreach ($drpublishApiClientTags as $drpublishApiClientTag) { ?>
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