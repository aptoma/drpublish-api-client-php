<? include('inc/search-meta.inc.php') ?>
<? include('inc/search-paginator.inc.php') ?>
<h2>Search articles [DrPublishApiWebClient::searchArticle('<?=$query?>', <?=$limit?>, <?=$offset?>)]</h2>

<ul>

<?php
	foreach ($drPublishApiClientSearchList as $drpublishApiClientArticle) {
		?>
		<li>
				[<?=$drpublishApiClientArticle->getId()?>]
				<strong><?=$drpublishApiClientArticle->getTitle()?></strong>
                <br/>
            <span style="color: #555">
                published: <?=$drpublishApiClientArticle->getPublished() ?> | written by: <?=$drpublishApiClientArticle->getDPAuthors() ?> |
                categories: <?=$drpublishApiClientArticle->getDPCategories() ?> |
                tags:  <?=$drpublishApiClientArticle->getDPTags() ?>
                <br/>
               <?=$drpublishApiClientArticle->getPreamble()?>
                </span>
		</li>
		<?php
	}
?>
</ul>
<? include('inc/search-paginator.inc.php') ?>