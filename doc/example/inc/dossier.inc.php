<h2>Dossier</h2>
<strong><?php print($drPublishApiClientDossier->getName()) ?></strong>
 [id=<?php print($drPublishApiClientDossier->getId()) ?>]
<br />
 Parent dossier name: <?php print($drPublishApiClientDossier->getParentName()) ?>
<br />
 original id: <?php print($drPublishApiClientDossier->getOriginalId()) ?>
<br />
 start: <?php print($drPublishApiClientDossier->getStart()) ?>
<br />
expire: <?php print($drPublishApiClientDossier->getExpire()) ?>
<span style="color: #666">
<br/>
</span>
<?php print(printSourceCode()) ?>