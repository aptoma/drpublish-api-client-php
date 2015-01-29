<h2>Sources search</h2>
<?php include('inc/search-meta.inc.php') ?>
<?php include('inc/functions.php') ?>
<br/>
<ul>
<?php foreach ($drPublishApiClientSearchList as $drPublishApiClientSource) { ?>
    <li>
        <strong><?php print($drPublishApiClientSource->getName())?></strong>
         [id=<?php print($drPublishApiClientSource->getId()) ?>]
        <br />
        <span style="color: #666">
        </span>
    </li>
<?php } ?>
</ul>
<?php include('inc/search-paginator.inc.php') ?>
<?php print(printSourceCode()) ?>
