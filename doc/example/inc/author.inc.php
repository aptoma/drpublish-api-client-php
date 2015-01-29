<?php include('inc/functions.php') ?>
<h2>Author</h2>
Name: <strong><?php print($drPublishApiClientAuthor->getFullName()) ?></strong>
<br/>
Username: <?php print($drPublishApiClientAuthor->getUserName()) ?>
<br/>
Email: <?php print($drPublishApiClientAuthor->getEmail()) ?>
<br/>
Twitter username: <?php print($drPublishApiClientAuthor->getTwitterUsername()) ?>
<br/>
Profile images: <?php print_r($drPublishApiClientAuthor->getProfileImages()) ?>
<br/>
<hr/>
All properties:
<pre>
<?php print_r($drPublishApiClientAuthor)?>
</pre>
<?php print(printSourceCode()) ?>