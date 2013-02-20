<h2>Dossier search</h2>
<?php include('inc/search-meta.inc.php') ?>
<ul>
<?php foreach ($drPublishApiClientSearchList as $drPublishApiClientDossier) { ?>
    <li>
        <strong><?php print($drPublishApiClientDossier->getName()) ?></strong>
         [id=<?php print($drPublishApiClientDossier->getId()) ?>]
        <br />
        <span style="color: #666">
        </span>
    </li>
<?php } ?>
</ul>
<?php include('inc/search-paginator.inc.php') ?>
<?php print(printSourceCode()) ?>
