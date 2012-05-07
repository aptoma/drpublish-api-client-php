<h2>Category search</h2>
<? include('inc/search-meta.inc.php') ?>
<ul>
<? foreach ($drPublishApiClientSearchList as $drPublishApiClientCategory) { ?>
    <li>
        <strong><?= $drPublishApiClientCategory->getName() ?></strong>
         [id=<?= $drPublishApiClientCategory->getId() ?>]
        <br />
        Parent category: <?=$drPublishApiClientCategory->getParentName() ?>
        <span style="color: #666">
        </span>
    </li>
<? } ?>
</ul>
<? include('inc/search-paginator.inc.php') ?>
<?= printSourceCode() ?>
