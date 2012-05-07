<h2>Author</h2>
Name: <strong><?=$drPublishApiClientAuthor->getFullName() ?></strong>
<br/>
Username: <?= $drPublishApiClientAuthor->getUserName() ?>
<br/>
Email: <?= $drPublishApiClientAuthor->getEmail() ?>
<br/>
Twitter username: <?= $drPublishApiClientAuthor->getTwitterUsername() ?>
<br/>
Profile images: <? print_r($drPublishApiClientAuthor->getProfileImages()) ?>
<br/>
<hr/>
All properties:
<pre>
<? print_r($drPublishApiClientAuthor)?>
</pre>
<?= printSourceCode() ?>