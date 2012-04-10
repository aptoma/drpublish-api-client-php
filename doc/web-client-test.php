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
require(dirname(__FILE__).'/../lib/web/DrPublishApiWebClient.php');

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
	var_dump($result);
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
        body {
            font-family: verdana, sans-serif;
            font-size: 12px;
        }

        h2 {
            width: 100%;
            background-color: #dde;
            font-size: 12px;
            margin: 15px 0 10px 0;
            clear: both;
            font-weight: normal;
            padding: 3px;
        }

        #main {
            width: 720px;
        }

        pre {
            font-size: 10px;
            max-height: 150px;
            overflow-y: auto;
            overflow-x: hidden;
            background: #def;
            padding: 5px;
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
<div id="main">
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
    <!--
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
-->
<script>
function setDPApiUrl(url)
{
	document.getElementById('dpurl2').value= url;
	document.getElementById('dpurl3').value= url;
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
    include('inc/article.inc.php');
 } /* end if ($runArticle)*/  else if ($runSearch) { ?>
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
</div>
</body>
</html>

