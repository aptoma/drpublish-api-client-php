<?php
/**
 * web-client-test.php
 * Tutorial and test for using the Web client
 *
 */
/**
 * Includes DrPublishApiWebClient
 */
require(dirname(__FILE__) . '/../../lib/web/DrPublishApiWebClient.php');
require('inc/functions.php');
ini_set('display_errors', 1);
$dpUrl = '';
$query = isset($_GET['query']) ? $_GET['query'] : '';
$limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
$start = isset($_GET['start']) ? (int) $_GET['start'] : 0;
$fields = isset($_GET['fields']) ? $_GET['fields'] : '';
$articleId = isset($_GET['article-id']) ? $_GET['article-id'] : 0;
$authorId = isset($_GET['author-id']) ? $_GET['author-id'] : 0;
$action = isset($_GET['action']) ? $_GET['action'] : '';
$publication = isset($_GET['publication']) ? $_GET['publication'] : '';

if (isset($_GET['dp-url'])) {
	$dpUrl = $_GET['dp-url'];
} else {
	if (file_exists(dirname(__FILE__).'/../WEB-INF/config/config.php')) {
		$serialized = file_get_contents(dirname(__FILE__).'/../WEB-INF/config/config.php');
		$configs = unserialize($serialized);
		$dpUrl = $configs['EXAMPLE_SITE_DPAPI_URL'];
	}
}
$dpWebClient = new DrPublishApiWebClient($dpUrl, $publication);

include('inc/head.inc.php');

if ($action == 'author') {
	try {
	    $drpublishApiClientAuthor = $dpWebClient->getAuthor($authorId);
        include('inc/author.inc.php');
	} catch (DrPublishApiClientException $e) {
        include('inc/error.inc.php');
	}
}
else if ($action == 'article') {
	try {
	    $drpublishApiClientArticle = $dpWebClient->getArticle($articleId);
        include('inc/article.inc.php');
	} catch (DrPublishApiClientException $e) {
        include('inc/error.inc.php');
	}
 }
else if ($action == 'search') {
	try {
        $options = array();
        if (!empty($start)) {
            $options['start'] = $start;
        }
        if (!empty($limit)) {
            $options['limit'] = $limit;
        }
        if (!empty($fields)) {
            $options['fields'] = $fields;
        }
        $query = trim($query);
        $query = urlencode(urldecode($query));
	    $drpublishApiClientArticles = $dpWebClient->searchArticles($query, $options);
        include('inc/search.inc.php');
	} catch (DrPublishApiClientException $e) {
        include('inc/error.inc.php');
	}
}

include('inc/foot.inc.php');

