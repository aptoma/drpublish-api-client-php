<?php include('inc/search-meta.inc.php') ?>
<?php include('inc/search-paginator.inc.php') ?>
<?php include('inc/functions.php') ?>
<h2>Search articles</h2>
<ul>
<?php
foreach ($drPublishApiClientSearchList as $drPublishApiClientArticle) { ?>
    <li>
        [<?php print($drPublishApiClientArticle->getId()) ?>]
        <a href="#" onclick="DrPublishApiClientExample.showArticle('<?php print($drPublishApiClientArticle->getId()) ?>');return false"><strong><?php print($drPublishApiClientArticle->getTitle()) ?></strong></a>
        <br/>
        <span style="color: #555">
            published: <?php print($drPublishApiClientArticle->getPublished()) ?> | written by: <?php print($drPublishApiClientArticle->getDPAuthors()) ?> |
            categories: <?php print($drPublishApiClientArticle->getDPCategories()) ?> |
            tags:  <?php print($drPublishApiClientArticle->getDPTags()) ?>
            <br/>
            <?php print($drPublishApiClientArticle->getPreamble())?>
        </span>
    </li>
<?php } ?>
</ul>
<?php include('inc/search-paginator.inc.php') ?>
<?php print(printSourceCode()) ?>