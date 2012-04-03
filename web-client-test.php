<?php
/**
 * web-client-test.php
 * Tutorial and test for using the Web client
 *
 * @package    no.aptoma.drpublish.client.web
 */
/**
 * Includes DrPublishApiWebClient
 */
require(dirname(__FILE__).'/web/DrPublishApiWebClient.php');

ini_set('display_errors', 1);

$dpUrl = '';
$run = isset($_GET['run']);
$runArticle = isset($_GET['run-article']);
$runAuthor = isset($_GET['run-author']);
$runSearch = isset($_GET['run-search']);
$articleId = isset($_GET['article-id']) ? $_GET['article-id'] : 0;
$authorId = isset($_GET['author-id']) ? $_GET['author-id'] : 0;

$query = isset($_GET['query']) ? $_GET['query'] : 'sort:published';
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
$start = isset($_GET['start']) ? (int) $_GET['start'] : 0;
if (isset($_GET['dp-url'])) {
	$dpUrl = $_GET['dp-url'];
} else {
	if (file_exists(dirname(__FILE__).'/../WEB-INF/config/config.php')) {
		$serialized = file_get_contents(dirname(__FILE__).'/../WEB-INF/config/config.php');
		$configs = unserialize($serialized);
		$dpUrl = $configs['EXAMPLE_SITE_DPAPI_URL'];
	}
}

function printResult($result) {
	ob_start();
	print '<pre>';
	var_dump($result);
	print '</pre>';
	$out = ob_get_contents();
	ob_end_clean();
	return $out;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
<head>
<title>Web client test</title>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<style>
h2 {
	width: 100%;
	background-color: #dde;
	font-size: 16px;
	margin: 50px 0 20px 0;
	clear: both;
}

.content-container {
	width: 710px;
	border: solid #88a 2px;
	padding: 5px;
	clear: both;
}

.error-message {
	display: block;
	padding: 10px;
	margin: 20px;
	background-color: #FFA500;
	width: 600px
}
</style>
</head>
<body>
<div>
<form action="">
	DrPublish API URL
	<input type="text" value="<?=$dpUrl?>" name="dp-url" style="width: 400px" onchange="setDPApiUrl(this.value)"/>
	<hr/>
	Article id:
	<input type="text" value="<?=$articleId?>" name="article-id" style="width: 60px" />
	<input type="submit" name="run-article" value="Show article" />
	<input type="hidden" name="run" value="true" />
</form>
<br /> ...or..<br />
<form action="">
	<input type="hidden" id="dpurl2" value="<?=$dpUrl?>" name="dp-url" style="width: 400px" />
	Search query:
	<input type="text" name="query" value="<?=$query?>" style="width: 300px"/>
	Limit:<input type="text" name="limit" value="<?=$limit?>" style="width: 40px"/>
	Start:<input type="text" name="start" value="<?=$start?>" style="width: 40px"/>
	<input type="submit" name="run-search" value="Search" />
	<input type="hidden" name="run" value="true" />
</form>
<br /> ...or..<br />
<form action="">
	<input type="hidden" id="dpurl3" value="<?=$dpUrl?>" name="dp-url" style="width: 400px" />
	Author id:
	<input type="text" value="<?=$authorId?>" name="author-id" style="width: 60px" />
	<input type="submit" name="run-author" value="Show author" />
	<input type="hidden" name="run" value="true" />
</form>
<script>
function setDPApiUrl(url)
{
	document.getElementById('dpurl2').value=url;
	document.getElementById('dpurl3').value=url;
}
</script>

<?php if (!$run) {
	die('</body></html>');
}?></div>

<?php

$dpWebClient = new DrPublishApiWebClient($dpUrl, 'DinePenger');

if ($runAuthor) {
	try {
	$drpublishApiClientAuthor = $dpWebClient->getAuthor($authorId);
	} catch (DrPublishApiClientException $e) {
		die ("<em class=\"error-message\">An exception has been raised: " . $e->getMessage() . "</em></body></html>");
	}
?>

<h2>Author</h2>
<?= printResult($drpublishApiClientAuthor)?>

<?php } else if ($runArticle) {
	try {
	$drpublishApiClientArticle = $dpWebClient->getArticle($articleId);
	} catch (DrPublishApiClientException $e) {
		die ("<em class=\"error-message\">An exception has been raised: " . $e->getMessage() . "</em></body></html>");
	}
?>



<h2>Source [DrPublishApiClientArticleElement DrPublishApiWebClient::getSourceName()]</h2>
<?=$drpublishApiClientArticle->getSourceName()?>

<h2>Published [DrPublishApiClientArticleElement DrPublishApiWebClient::getPublished()]</h2>
<?=$drpublishApiClientArticle->getPublished()?>

<h2>Modified [DrPublishApiClientArticleElement DrPublishApiWebClient::getModified()]</h2>
<?=$drpublishApiClientArticle->getModified()?>

<h2>Tags [DrPublishApiClientList DrPublishApiWebClient::getTagNames()]</h2>
<?=$drpublishApiClientArticle->getTagNames()   ?>

<h2 style="display:none">DPTags as dedicated DrPublishApiClientTag objects [DrPublishApiClientList
DrPublishApiWebClient::getDPTags()]</h2>

<? //= printResult($drpublishApiClientArticle->getDPTags())    ?>

<h2>Categories [DrPublishApiClientList DrPublishApiWebClient::getCategories()]</h2>
<?=
    $drpublishApiClientArticle->getCategories()
 ?>

<h2 style="display:none">DPCategories as dedicated DrPublishApiClientCategory objects [DrPublishApiClientListDrPublishApiWebClient::getDPCategories()]</h2>
<? //=printResult($drpublishApiClientArticle->getDPCategories())   ?>

<h2>DPCategorys' parent category DrPublishApiClientCategory objects [DrPublishApiClientCategory::getParent()]</h2>
<?php
//foreach ($drpublishApiClientArticle->getDPCategories() as $drpublishApiClientCategory) {
//	print printResult($drpublishApiClientCategory->getParent());
//}
?>

<h2>Main category [DrPublishApiClientArticleElement
DrPublishApiWebClient::getMainCategoryName()]</h2>
<?= $drpublishApiClientArticle->getMainCategoryName()  ?>

<h2>Authors as simple list DrPublishApiClientArticleElement [DrPublishApiClientList
DrPublishApiWebClient::getAuthorNames()]</h2>
<?=
    $drpublishApiClientArticle->getAuthorNames()
    ?>

<h2>Authors as DrPublishApiClientAuthor list [DrPublishApiClientList
DrPublishApiWebClient::getDPAuthors()]</h2>
<?
    //$drpublishApiClientArticle->getDPAuthors()
    ?>
<?
 //printResult($drpublishApiClientArticle->getDPAuthors())
    ?>

<h2>Authors [DrPublishApiClientList DrPublishApiWebClient::getAuthorNames()]</h2>
<?
    //$drpublishApiClientArticle->getAuthorNames()
    ?>

<h1>--Content--</h1>

<h2>Title [DrPublishApiClientArticleElement DrPublishApiWebClient::getTitle()]</h2>

<h3><?=$drpublishApiClientArticle->getTitle()?></h3>

<h2>Preamble [DrPublishApiClientArticleElement DrPublishApiWebClient::getPreamble()]</h2>
<div class="content-container"><b> <?=$drpublishApiClientArticle->getPreamble()?>
</b></div>

<h2>LeadAsset [DrPublishApiClientArticleElement DrPublishApiWebClient::getLeadAsset()]</h2>
<?php $leadAsset = $drpublishApiClientArticle->getLeadAsset() ?>
<div class="content-container"><?=($leadAsset != null) ? $leadAsset->content() : '' ?>
<div style="clear: both"></div>
</div>

<h2>Body Text [DrPublishApiClientArticleElement DrPublishApiWebClient::getBodyText()]</h2>
<div class="content-container"><?=$drpublishApiClientArticle->getBodyText()?></div>

    <? exit ?>

<h2>All images [DrPublishApiClientList DrPublishApiWebClient::getImages()]</h2>
<div class="content-container"><?=$drpublishApiClientArticle->getImages()?>
<h3>Image URL's [array DrPublishApiClientList::getAttributes('src')]</h3>
<?= printResult($drpublishApiClientArticle->getImages()->getAttributes('src'))?></div>

<h2>DPImages</h2>
<h3>Including wrapping markups [DrPublishApiClientList DrPublishApiWebClient::getDPImages()]</h3>
<div class="content-container"><?=$drpublishApiClientArticle->getDPImages()?> <?php
$drpublishApiClientImages = $drpublishApiClientArticle->getDPImages();
foreach ($drpublishApiClientImages as $drpublishApiClientImage) {
	print "<br/><br/> photographer: ";
	printResult($drpublishApiClientImage->getPhotographer());
	print "<br/> title: " . $drpublishApiClientImage->getTitle();
	print "<br/> description: " . $drpublishApiClientImage->getDescription();
	print "<br/> source: " . $drpublishApiClientImage->getSource();
	print "<br/> image element " . 	$drpublishApiClientImage->getImage();
}
?>
<h3>Thumbnails [DrPublishApiWebClientArticleElement
DrPublishApiWebClientImageElement::getThumbnail(size)]</h3>
<pre>
<?php
foreach ($drpublishApiClientImages as $drpublishApiClientImageElement) {
	$drpublishApiClientImage = $drpublishApiClientImageElement->getThumbnail(75);
	print printResult($drpublishApiClientImage);
	print ($drpublishApiClientImage);
	print " width=" . $drpublishApiClientImage->getWidth();
	print " src=" . $drpublishApiClientImage->getUrl();
}

?></div>
</pre>

<h2>Fact Boxes [DrPublishApiClientList DrPublishApiWebClient::getFactBoxes()]</h2>
<div class="content-container"><?=$drpublishApiClientArticle->getFactBoxes();?></div>

<?php } /* end if ($runArticle)*/  else if ($runSearch) { ?>
<h2>Search articles [DrPublishApiWebClient::searchArticle('<?=$query?>', <?=$limit?>, <?=$start?>)]</h2>


<?php
	try {
	$drpublishApiClientArticles = $dpWebClient->searchArticles($query , $limit, $start);
	} catch (DrPublishApiClientException $e) {
		die ("<em class=\"error-message\">An exception has been raised: " . $e->getMessage() . "</em></body></html>");
	}
?>

<ul>
<?php

	foreach ($drpublishApiClientArticles as $drpublishApiClientArticle) {
		?>
		<li>
			<h4>
				<?=$drpublishApiClientArticle->getId()?>:
				<a href="web-client-test.php?run=true&run-article=true&article-id=<?=$drpublishApiClientArticle->getId()?>&dp-url=<?=$dpUrl?>">
				<?=$drpublishApiClientArticle->getTitle()?>
				</a>
			</h4>

		</li>
		<?php
	}

?>
</ul>

<?php } /* end if ($runSearch)*/ ?>
</body>
</html>

