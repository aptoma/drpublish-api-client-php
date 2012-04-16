<h2>Tag</h2>
    <strong><?= $drpublishApiClientTag->getName() ?></strong>
     [id=<?= $drpublishApiClientTag->getId() ?>]
    <br />
    <span style="color: #666">
    Type: <?=$drpublishApiClientTag->getTagTypeName(); ?> (id=<?=$drpublishApiClientTag->getTagTypeId(); ?>)
        <br/>
    Content:  <?= htmlentities($drpublishApiClientTag->getContent()); ?>
    </span>
