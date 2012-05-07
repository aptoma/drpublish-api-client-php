<h2>Tag</h2>
<strong><?= $drPublishApiClientTag->getName() ?></strong>
 [id=<?= $drPublishApiClientTag->getId() ?>]
<br />
<span style="color: #666">
Type: <?=$drPublishApiClientTag->getTagTypeName(); ?> (id=<?=$drPublishApiClientTag->getTagTypeId(); ?>)
    <br/>
Content:  <?= htmlentities($drPublishApiClientTag->getContent()); ?>
</span>
<?= printSourceCode() ?>