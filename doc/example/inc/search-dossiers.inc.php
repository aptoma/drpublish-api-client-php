<h2>Dossier search</h2>
<? include('inc/search-meta.inc.php') ?>
<ul>
<? foreach ($drPublishApiClientSearchList as $drPublishApiClientDossier) { ?>
    <li>
        <strong><?= $drPublishApiClientDossier->getName() ?></strong>
         [id=<?= $drPublishApiClientDossier->getId() ?>]
        <br />
        <span style="color: #666">
        </span>
    </li>
<? } ?>
</ul>
<? include('inc/search-paginator.inc.php') ?>
<?= printSourceCode() ?>
