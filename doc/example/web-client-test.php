<?php
/**
 * web-client-test.php
 * Tutorial and test for using the Web client
 *
 */
require('vendor/autoload.php');
ini_set('display_errors', 1);
$action = isset($_GET['action']) ? $_GET['action'] : '';
$publication = isset($_GET['publication']) ? $_GET['publication'] : '';
$isInternal = isset($_GET['internal']) && ($_GET['internal'] == '1');
$isArticlePreview = isset($_GET['internal']) && ($_GET['internal'] == '2');
$apiKey = isset($_GET['dp-apikey']) ? $_GET['dp-apikey'] : null;
$dpUrl = '';
$dpUrlInternal = $_GET['dp-url-internal'];

if ($isInternal) {
	$dpUrl = $_GET['dp-url-internal'];
} else {
	$dpUrl = $_GET['dp-url'];
}
$isSSL = strpos($dpUrl, 'https') === 0;

$procStart = microtime(true);
$dpWebClient = new DrPublishApiWebClient($dpUrl, $publication);
if ($isInternal) {
    $dpWebClient = $dpWebClient->internalScopeClient($apiKey, $dpUrlInternal);
}
$dpWebClient->setDebugMode();

switch ($action) {
    case 'article':
        try {
            $articleId = isset($_GET['article-id']) ? $_GET['article-id'] : 0;
            if ($isArticlePreview) {
                $drPublishApiClientArticle = $dpWebClient->getArticlePreview($articleId, $apiKey, $dpUrlInternal);
            } else {
                $drPublishApiClientArticle = $dpWebClient->getArticle($articleId, $isSSL? $apiKey : null);
            }
            $mainView = 'article';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'search':
        try {
           if (isset($_GET['readyRequest'])) {
               $get = $_GET;
               $offset = isset($get['offset']) ? $get['offset'] : 0;
               $limit = isset($get['limit']) ? $get['limit'] : 5;
               unset($get['offset']);
               unset($get['limit']);
               unset($get['readyRequest']);
               unset($get['dp-url']);
               unset($get['action']);
               $query = '';
               foreach($get as $key => $value) {
                   $query .= '&' . $key.  '=' . urlencode($value) ;
               }
           }  else {
               $query = parseFilterFieldsRequest();
               $order = isset($_GET['order']) ?  $_GET['order'] : false;
               if ($order && strpos($order, '--') === false ) {
                   $query .= '&order=' . urlencode($order);
               }
               $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
               $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
           }
           $options = array();
           $drPublishApiClientSearchList = $dpWebClient->searchArticles($query, $limit, $offset, $options);
           $mainView = 'search';
        } catch (DrPublishApiClientException $e) {
           $mainView = 'error';
        }
        break;
    case 'search-authors':
        try {
          $query = parseFilterFieldsRequest();
          $requestedFields = array();
          $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
          $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
          $drPublishApiClientSearchList = $dpWebClient->searchAuthors($query, $limit, $offset);
          $mainView = 'search-authors';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'author':
        try {
            $authorId = isset($_GET['author-id']) ? $_GET['author-id'] : 0;
            $drPublishApiClientAuthor = $dpWebClient->getAuthor($authorId);
            $mainView = 'author';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'search-tags':
        try {
          $query = parseFilterFieldsRequest();
          $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
          $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
          $drPublishApiClientSearchList = $dpWebClient->searchTags($query, $limit, $offset);
          $mainView = 'search-tags';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'tag':
        try {
            $tagId = isset($_GET['tag-id']) ? $_GET['tag-id'] : 0;
            $drPublishApiClientTag = $dpWebClient->getTag($tagId);
            $mainView = 'tag';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'search-categories':
        try {
          $query = parseFilterFieldsRequest();
          $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
          $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
          $drPublishApiClientSearchList = $dpWebClient->searchCategories($query, $limit, $offset);
          $mainView = 'search-categories';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'category':
        try {
            $categoryId = isset($_GET['category-id']) ? $_GET['category-id'] : 0;
            $drPublishApiClientCategory = $dpWebClient->getCategory($categoryId);
            $mainView = 'category';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'search-sources':
        try {
          $query = parseFilterFieldsRequest();
          $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
          $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
          $drPublishApiClientSearchList = $dpWebClient->searchSources($query, $limit, $offset);
          $mainView = 'search-sources';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'source':
        try {
            $sourceId = isset($_GET['source-id']) ? $_GET['source-id'] : 0;
            $drPublishApiClientSource = $dpWebClient->getSource($sourceId);
            $mainView = 'source';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    default :
        $mainView = 'action-not-found';

}

function parseFilterFieldsRequest()
{
    $query = '';
    $filterFields = isset($_GET['filterFields']) ?  $_GET['filterFields'] : false;
    if ($filterFields) {
        $params = array();
        foreach ($filterFields as  $filterField) {
            if (strpos($filterField['key'], '--') === false) {
                $params[$filterField['key']] = $filterField['value'];
            }
        }
        $query = http_build_query($params);
    }
    if ($filterFields && count($filterFields) > 1 && isset($_GET['conditionType'])) {
       $query .= '&conditionType=' . $_GET['conditionType'];
    }

    return $query;
}
$curlInfo = $dpWebClient->getCurlInfo();
$curlTime = $curlInfo['total_time'];
$curlDLSpeed = round(($curlInfo['speed_download'] * 8) / (1024*1024)) ;
$curlDLSize = round($curlInfo['size_download'] / (1024*1024), 2);

// Render views

include('inc/head.inc.php');
include('inc/api-request.inc.php');
include('inc/' . $mainView . '.inc.php');
$procDuration = microtime(true) - $procStart;
include('inc/foot.inc.php');

