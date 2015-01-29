<h2>Category search</h2>
<?php include('inc/search-meta.inc.php') ?>
<?php include('inc/functions.php') ?>
<ul>
<?php foreach ($drPublishApiClientSearchList as $drPublishApiClientCategory) { ?>
    <li>
        <strong><?php print($drPublishApiClientCategory->getName()) ?></strong>
         [id=<?php print($drPublishApiClientCategory->getId()) ?>]
        <br />
        Parent category: <?php print($drPublishApiClientCategory->getParentName()) ?>
        <span style="color: #666">
        </span>
    </li>
<?php } ?>
</ul>
<?php include('inc/search-paginator.inc.php') ?>
<?php print(printSourceCode()) ?>
