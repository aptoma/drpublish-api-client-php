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

}

$dpWebClient = new DrPublishApiWebClient($dpUrl, $publication);
$dpWebClient->setDebugMode();

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
           if (isset($_GET['readyRequest'])) {
               $get = $_GET;
               $offset = $get['offset'];
               $limit = $get['limit'];
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
               $query = '&' . parseFilterFieldsRequest();
               $order = isset($_GET['order']) ?  $_GET['order'] : false;
               if ($order && strpos($order, '--') === false ) {
                   $query .= '&order=' . urlencode($order);
               }
               $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
               $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
           }
           $options = array();
           if (!empty($offset)) {
               $options['offset'] = $offset;
           }
           if (!empty($limit)) {
               $options['limit'] = $limit;
           }
           $drPublishApiClientSearchList = $dpWebClient->searchArticles($query, $options);
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
          $drPublishApiClientSearchList = $dpWebClient->searchAuthors($query, $offset, $limit);
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
          $query = parseFilterFieldsRequest();
          $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
          $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
          $drPublishApiClientSearchList = $dpWebClient->searchTags($query, $offset, $limit);
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
    case 'search-categories':
        try {
          $query = parseFilterFieldsRequest();
          $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
          $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
          $drPublishApiClientSearchList = $dpWebClient->searchCategories($query, $offset, $limit);
          $mainView = 'search-categories';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'category':
        try {
            $categoryId = isset($_GET['category-id']) ? $_GET['category-id'] : 0;
            $drpublishApiClientCategory = $dpWebClient->getCategory($categoryId);
            $mainView = 'category';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'search-dossiers':
        try {
          $query = parseFilterFieldsRequest();
          $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
          $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
          $drPublishApiClientSearchList = $dpWebClient->searchDossiers($query, $offset, $limit);
          $mainView = 'search-dossiers';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'dossier':
        try {
            $dossierId = isset($_GET['dossier-id']) ? $_GET['dossier-id'] : 0;
            $drpublishApiClientDossier = $dpWebClient->getDossier($dossierId);
            $mainView = 'dossier';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'search-sources':
        try {
          $query = parseFilterFieldsRequest();
          $limit = isset($_GET['limit']) ? (int) $_GET['limit'] : 5;
          $offset = isset($_GET['offset']) ? (int) $_GET['offset'] : 0;
          $drPublishApiClientSearchList = $dpWebClient->searchSources($query, $offset, $limit);
          $mainView = 'search-sources';
        } catch (DrPublishApiClientException $e) {
            $mainView = 'error';
        }
        break;
    case 'source':
        try {
            $sourceId = isset($_GET['source-id']) ? $_GET['source-id'] : 0;
            $drpublishApiClientSource = $dpWebClient->getSource($sourceId);
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
        foreach ($filterFields as $key =>  $filterField) {
            if (strpos($filterField['key'], '--') === false) {
                $val = urlencode( $filterField['value']);
                if ($query != '') {
                    $query .= '&';
                }
                if ($key > 1) {
                    $condition = $filterField['condition'];
                    $query .= $filterField['key'].  '=' . $val ;
                    $query .= '&conditionType=' . $condition;
                }
            }
        }
    }
    return $query;
}


// Render views

include('inc/head.inc.php');
include('inc/api-request.inc.php');
include('inc/' . $mainView . '.inc.php');
include('inc/foot.inc.php');

