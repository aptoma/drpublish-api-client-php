<? include('api-request.inc.php') ?>
<h2>Search articles [DrPublishApiWebClient::searchArticle('<?=$query?>', <?=$limit?>, <?=$start?>)]</h2>
<ul>
<?php
	foreach ($drpublishApiClientArticles as $drpublishApiClientArticle) {
		?>
		<li>
			<h4>
				<?=$drpublishApiClientArticle->getId()?>:
				<a href="web-client-test.php?action=article&article-id=<?=$drpublishApiClientArticle->getId()?>&dp-url=<?=$dpUrl?>&publication=<?=$publication?>&query=<?=$query?>">

				<?=$drpublishApiClientArticle->getTitle()?>
				</a>
			</h4>

		</li>
		<?php
	}
?>
</ul>