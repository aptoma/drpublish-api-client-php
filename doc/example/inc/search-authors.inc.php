<?php include('inc/search-meta.inc.php') ?>
<?php include('inc/functions.php') ?>
    <h2>Author search</h2>
<ul>
<?php foreach ($drPublishApiClientSearchList as $drPublishApiClientAuthor) { ?>
    <li>
        <strong><?php print($drPublishApiClientAuthor->getFullName()) ?></strong>
         [id=<?php print($drPublishApiClientAuthor->getId()) ?>, username=<?php print($drPublishApiClientAuthor->getUserName()) ?>]
         [id=<?php print($drPublishApiClientAuthor->getId()) ?>, username=<?php print($drPublishApiClientAuthor->getUserName()) ?>]
    </li>
<?php } ?>
</ul>
<?php include('inc/search-paginator.inc.php') ?>
<?php print(printSourceCode()) ?>