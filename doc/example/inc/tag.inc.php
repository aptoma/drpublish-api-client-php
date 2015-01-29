<?php include('inc/functions.php') ?>
<h2>Tag</h2>
<strong><?php print($drPublishApiClientTag->getName()) ?></strong>
 [id=<?php print($drPublishApiClientTag->getId()) ?>]
<br />
<span style="color: #666">
Type: <?php print($drPublishApiClientTag->getTagTypeName())?> (id=<?php print($drPublishApiClientTag->getTagTypeId()) ?>)
    <br/>
Content:  <?php print(htmlentities($drPublishApiClientTag->getContent())) ?>
</span>
<?php print(printSourceCode()) ?>