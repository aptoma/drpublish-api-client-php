<?php include('inc/search-meta.inc.php') ?>
<?php include('inc/functions.php') ?>
<h2>Tag search</h2>
<ul>
<?php foreach ($drPublishApiClientSearchList as $drPublishApiClientTag) { ?>
    <li>
        <strong><?php print($drPublishApiClientTag->getName()) ?></strong>
         [id=<?php print($drPublishApiClientTag->getId()) ?>]
        <br />
        <span style="color: #666">
        Type: <?php print($drPublishApiClientTag->getTagTypeName()) ?> (id=<?php print($drPublishApiClientTag->getTagTypeId()) ?>)
            <br/>
        Content:  <?php print(htmlentities($drPublishApiClientTag->getContent())) ?>
        </span>
    </li>
<?php } ?>
</ul>
<?php include('inc/search-paginator.inc.php') ?>
<?php print(printSourceCode()) ?>
