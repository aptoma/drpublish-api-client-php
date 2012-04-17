<?php
/**
 * web-client-test.php
 * Tutorial and test for using the Web client
 *
 */
require(dirname(__FILE__) . '/../../lib/web/DrPublishApiWebClient.php');
require('inc/functions.php');
ini_set('display_errors', 1);
$action = isset($_GET['action']) ? $_GET['action'] : '';
$publication = isset($_GET['publication']) ? $_GET['publication'] : '';
$dpUrl = '';
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

switch ($action) {
    case 'article':
        try {
            $articleId = isset($_GET['article-id']) ? $_GET['article-id'] : 0;
            $drpublishApiClientArticle = $dpWebClient->getArticle($articleId);
            $mainView = 'article';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'search':

        try {
           $query = '';
           $dynamicQuery = isset($_GET['dynamicQuery']) ? trim($_GET['dynamicQuery']) : '';

           $filterFields = isset($_GET['filterFields']) ?  $_GET['filterFields'] : false;
           if ($filterFields) {
               foreach ($filterFields as $filterField) {
                   if (strpos($filterField['key'], '--') === false) {
                       $val = urlencode('"' . $filterField['value']. '"');
                        $query .= '&' . $filterField['key'].  '=' . $val ;
                   }
               }
           }

           if (!empty($dynamicQuery)) {
               $query .= '&dynamicQuery=' . $dynamicQuery;
           }
           $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
           $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
           $options = array();
           if (!empty($offset)) {
               $options['offset'] = $offset;
           }
           if (!empty($limit)) {
               $options['limit'] = $limit;
           }

   	       $drpublishApiClientArticles = $dpWebClient->searchArticles($query, $options);
           $mainView = 'search';
        } catch (DrPublishApiClientException $e) {
           $mainView = 'error';
        }
        break;
    case 'search-authors':
        try {
          $requestedFields = array();
          if (!empty($_GET['fullname'])) $requestedFields[] = "fullname={$_GET['fullname']}";
          if (!empty($_GET['username'])) $requestedFields[] = "username={$_GET['username']}";
          //$query = isset($_GET['query']) ? $_GET['query'] : '';
          //$query = trim(urlencode(urldecode($query)));
          $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
          $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;

          $query = join('&', $requestedFields);
          $drpublishApiClientAuthors = $dpWebClient->searchAuthors($query, $offset, $limit);
          $mainView = 'search-authors';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'author':
        try {
            $authorId = isset($_GET['author-id']) ? $_GET['author-id'] : 0;
            $drpublishApiClientAuthor = $dpWebClient->getAuthor($authorId);
            $mainView = 'author';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'search-tags':
        try {
          $requestedFields = array();
          if (!empty($_GET['name'])) $requestedFields[] = "name={$_GET['name']}";
         // if (!empty($_GET['username'])) $requestedFields[] = "username={$_GET['username']}";
          //$query = isset($_GET['query']) ? $_GET['query'] : '';
          //$query = trim(urlencode(urldecode($query)));
          $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
          $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
          $query = join('&', $requestedFields);
          $drpublishApiClientTags = $dpWebClient->searchTags($query, $offset, $limit);
          $mainView = 'search-tags';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'tag':
        try {
            $tagId = isset($_GET['tag-id']) ? $_GET['tag-id'] : 0;
            $drpublishApiClientTag = $dpWebClient->getTag($tagId);
            $mainView = 'tag';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;

    default :
        $mainView = 'action-not-found';

}


// Render views

include('inc/head.inc.php');
include('inc/api-request.inc.php');
include('inc/' . $mainView . '.inc.php');
include('inc/foot.inc.php');

