<h2>Category</h2>
<strong><?= $drPublishApiClientCategory->getName() ?></strong>
 [id=<?= $drPublishApiClientCategory->getId() ?>]
<br />
Parent category id: <?=$drPublishApiClientCategory->getParentId() ?>
<br />
Parent category name: <?=$drPublishApiClientCategory->getParentName() ?>
<span style="color: #666">
</span>
<?= printSourceCode() ?>