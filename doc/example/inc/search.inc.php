<? include('inc/search-meta.inc.php') ?>
<? include('inc/search-paginator.inc.php') ?>
<h2>Search articles</h2>
<ul>
<?php
foreach ($drPublishApiClientSearchList as $drPublishApiClientArticle) { ?>
    <li>
        [<?=$drPublishApiClientArticle->getId()?>]
        <strong><?=$drPublishApiClientArticle->getTitle()?></strong>
        <br/>
        <span style="color: #555">
            published: <?=$drPublishApiClientArticle->getPublished() ?> | written by: <?=$drPublishApiClientArticle->getDPAuthors() ?> |
            categories: <?=$drPublishApiClientArticle->getDPCategories() ?> |
            tags:  <?=$drPublishApiClientArticle->getDPTags() ?>
            <br/>
            <?=$drPublishApiClientArticle->getPreamble()?>
        </span>
    </li>
<?php } ?>
</ul>
<? include('inc/search-paginator.inc.php') ?>
<?= printSourceCode() ?>