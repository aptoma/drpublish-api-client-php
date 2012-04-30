<?php
$dpcDirname = dirname(__FILE__);
require($dpcDirname . '/helpers/DrPublishApiClientList.php');
require($dpcDirname . '/helpers/DrPublishApiClientSearchList.php');
require($dpcDirname . '/helpers/DrPublishDomElementList.php');
require($dpcDirname . '/helpers/DrPublishApiClientException.php');
require($dpcDirname . '/helpers/DrPublishApiClientHttpException.php');
require($dpcDirname . '/dom/DrPublishDomElement.php');
require($dpcDirname . '/dom/DrPublishDomText.php');
require($dpcDirname . '/entities/DrPublishApiClientArticleEntity.php');
require($dpcDirname . '/entities/DrPublishApiClientArticle.php');
require($dpcDirname . '/entities/DrPublishApiClientAuthor.php');
require($dpcDirname . '/entities/DrPublishApiClientCategory.php');
require($dpcDirname . '/entities/DrPublishApiClientTag.php');
require($dpcDirname . '/entities/DrPublishApiClientDossier.php');
require($dpcDirname . '/entities/DrPublishApiClientSource.php');
require($dpcDirname . '/content/DrPublishApiClientArticleElement.php');
require($dpcDirname . '/content/DrPublishApiClientXmlElement.php');
require($dpcDirname . '/content/DrPublishApiClientTextElement.php');
require($dpcDirname . '/content/DrPublishApiClientArticleImageElement.php');
unset($dpcDirname);
define('QUERY_TYPE_XPATH', 1);
define('QUERY_TYPE_JQUERY', 2);

class DrPublishApiClient
{
    protected $url;
    protected $requestUri;
    protected $searchQueryUrl;
    protected $debug = false;
    protected $publicationName;
    protected $medium = 'web';

    public function __construct($url, $publicationName)
    {
        $this->url = $url;
        $this->publicationName = $publicationName;
    }

    public function setMedium($medium)
    {
        $this->medium = $medium;
    }

    public function getMedium()
    {
        return $this->medium;
    }

    public function setDebugMode()
    {
        $this->debug = true;
    }

    public function getDebugMode()
    {
        return $this->debug;
    }

    public function setUnitTestMode()
    {
        $this->unitTestMode = true;
    }

    public function getUnitTestMode()
    {
        return $this->unitTestMode;
    }

    protected function _isPreviewRequest()
    {
        return isset($_REQUEST['dp-preview']);
    }

    public function serverError($msg, $httpStatusCode)
    {
        if ($httpStatusCode == 200) {
            throw new DrPublishApiClientException($msg, DrPublishApiClientException::NO_DATA_ERROR);
        } else {
            $e = new DrPublishApiClientHttpException($msg, DrPublishApiClientException::HTTP_ERROR);
            $e->setHttpError($httpStatusCode);
            throw $e;
        }
    }

    public function searchArticles($query, $limit = 5, $offset = 0, $options = array())
    {
        $query .= "&offset={$offset}";
        $query .= "&limit={$limit}";
        if (count($options) > 0) {
            foreach ($options as $key => $value) {
                $query .= "&{$key}={$value}";
            }
        }
        $url = $this->url . '/articles.json?publication=' . $this->publicationName . $query;
        $response = $this->curl($url);
        $result = json_decode($response->body);
        $drPublishApiClientSearchList = new DrPublishApiClientSearchList($result->search, $response->headers);
        $articles = $result->items;
        foreach ($articles as $article) {
            $drPublishApiClientSearchList->add($this->createDrPublishApiClientArticle($article));
        }
        return $drPublishApiClientSearchList;
    }

    public function getArticle($id)
    {
        $url = $this->url . '/articles/' . $id . '.json';
        $response = $this->curl($url);
        $resultJson = $response->body;
        $result = json_decode($resultJson);
        if (empty($result)) {
            throw new DrPublishApiClientException("No article data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientArticle($result);
    }

    public function getInternalArticle($id, $apikey)
    {
        $url = $this->url . '/articles/' . $id . '.json?scope=internal&apikey=' . $apikey;
        $response = $this->curl($url);
        $resultJson = $response->body;
        $result = json_decode($resultJson);
        if (empty($result)) {
            throw new DrPublishApiClientException("No article data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientArticle($result);
    }

    public function searchAuthors($query, $limit = 5, $offset = 0)
    {
        $query = urldecode($query);
        $url = $this->url . '/users.json?' . $query . '&offset=' . $offset . '&limit=' . $limit;
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        $drPublishApiClientSearchList = new DrPublishApiClientSearchList($responseObject->search, $response->headers);
        if (!empty($responseObject)) {
            $authors = $responseObject->items;
            foreach ($authors as $author) {
                $drPublishApiClientSearchList->add($this->createDrPublishApiClientAuthor($author));
            }
        }
        return ($drPublishApiClientSearchList);
    }

    public function getAuthor($id)
    {
        $url = $this->url . '/users/' . $id . '.json';
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        if (empty($responseObject)) {
            throw new DrPublishApiClientException("No or invalid author data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientAuthor($responseObject);
    }

    public function searchTags($query, $limit = 5, $offset = 0)
    {
        $query = urldecode($query);
        $url = $this->url . '/tags.json?' . $query . '&offset=' . $offset . '&limit=' . $limit;
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        $drPublishApiClientSearchList = new DrPublishApiClientSearchList($responseObject->search, $response->headers);
        if (!empty($responseObject)) {
            $tags = $responseObject->items;
            foreach ($tags as $tag) {
                $drPublishApiClientSearchList->add($this->createDrPublishApiClientTag($tag));
            }
        }
        return ($drPublishApiClientSearchList);
    }

    public function getTag($id)
    {
        $url = $this->url . '/tags/' . $id . '.json';
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        if (empty($responseObject)) {
            throw new DrPublishApiClientException("No or invalid author data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        $dpClientTag = $this->createDrPublishApiClientTag($responseObject);
        return $dpClientTag;
    }

    public function searchCategories($query, $limit = 5, $offset = 0)
    {
        $url = $this->url . '/categories.json?' . $query . '&offset=' . $offset . '&limit=' . $limit;
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        $drPublishApiClientSearchList = new DrPublishApiClientSearchList($responseObject->search, $response->headers);
        if (!empty($responseObject)) {
            $categories = $responseObject->items;
            foreach ($categories as $categoryData) {
                $drPublishApiClientSearchList->add($this->createDrPublishApiClientCategory($categoryData));
            }
        }
        return $drPublishApiClientSearchList;
    }

    public function getCategory($id)
    {
        $url = $this->url . '/categories/' . $id . '.json';
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        if (empty($responseObject)) {
            throw new DrPublishApiClientException("No article data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientCategory($responseObject);
    }

    public function searchDossiers($query, $limit = 5, $offset = 0)
    {
        $url = $this->url . '/dossiers.json?' . $query . '&offset=' . $offset . '&limit=' . $limit;
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        $drPublishApiClientSearchList = new DrPublishApiClientSearchList($responseObject->search, $response->headers);
        if (!empty($responseObject)) {
            foreach ($responseObject->items as $item) {
                $drPublishApiClientSearchList->add($this->createDrPublishApiClientDossier($item));
            }
        }
        return $drPublishApiClientSearchList;
    }

    public function getDossier($id)
    {
        $url = $this->url . '/dossiers/' . $id . '.json';
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        if (empty($responseObject)) {
            throw new DrPublishApiClientException("No article data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientDossier($responseObject);
    }

    public function searchSources($query, $limit = 5, $offset = 0)
    {
        $url = $this->url . '/sources.json?' . $query . '&offset=' . $offset . '&limit=' . $limit;
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        $drPublishApiClientSearchList = new DrPublishApiClientSearchList($responseObject->search, $response->headers);
        if (!empty($responseObject)) {
            foreach ($responseObject->items as $item) {
                $drPublishApiClientSearchList->add($this->createDrPublishApiClientSource($item));
            }
        }
        return $drPublishApiClientSearchList;
    }

    public function getSource($id)
    {
        $url = $this->url . '/sources/' . $id . '.json';
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        if (empty($responseObject)) {
            throw new DrPublishApiClientException("No article data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientSource($responseObject);
    }

    public function getRequestUri()
    {
        return $this->requestUri;
    }

    public function getSearchQueryUri()
    {
        return $this->searchQueryUrl;
    }

    protected function createDrPublishApiClientArticle($article)
    {
        return new DrPublishApiClientArticle($article, $this);
    }

    protected function createDrPublishApiClientAuthor($author)
    {
        $dpClientAuthor = new DrPublishApiClientAuthor($author);
        $dpClientAuthor->setId($dpClientAuthor->getProperty('id'));
        $dpClientAuthor->setFullName($dpClientAuthor->getProperty('fullname'));
        $dpClientAuthor->setUserName($dpClientAuthor->getProperty('username'));
        $dpClientAuthor->setEmail($dpClientAuthor->getProperty('email'));
        return $dpClientAuthor;
    }

    protected function createDrPublishApiClientDossier($dossier)
    {
        return new DrPublishApiClientDossier($dossier);
    }

    protected function createDrPublishApiClientSource($source)
    {
        return new DrPublishApiClientSource($source);
    }

    protected function createDrPublishApiClientTag($tag)
    {
        return new DrPublishApiClientTag($tag, $this);
    }

    protected function createDrPublishApiClientCategory($category)
    {
        return new DrPublishApiClientCategory($category, $this);
    }

    protected function curl($url)
    {
        $url = str_replace(' ', '+', $url);
        $this->requestUri = $url;
        if ($this->debug) {
            $url .= strpos($url, '?') === false ? '?' : '&';
            $url .= 'debug';
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_COOKIESESSION, false);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        $info = curl_getinfo($ch);
        $header = substr($res, 0, $info['header_size']);
        $this->searchQueryUrl = $header;
        $split = preg_split('#([\w|-]*): #', $header, -1, PREG_SPLIT_DELIM_CAPTURE);
        $headerArray = array();
        $headerArray['status'] = $split[0];
        for ($i = 1; $i < count($split) - 1; $i = $i + 2) {
            $headerArray[trim($split[$i])] = $split[$i + 1];
        }
        if (isset($headerArray['X-SearchServer-Query-URL'])) {
            $this->searchQueryUrl = $headerArray['X-SearchServer-Query-URL'];
        }
        $body = substr($res, $info['header_size']);
        curl_close($ch);
        if ($info['http_code'] == 404) {
            $this->serverError("Could not connect to DrPublish API: Server down or address misspelled? (requested URL=\"{$url}\") ", $info['http_code']);
        }
        else if ($info['http_code'] != 200) {
            $this->serverError("Error requesting DrPublish API: \"{$body}\" HTTP code is {$info['http_code']} ", $info['http_code']);
        }
        if (empty($body) || $body == '{}') {
            $this->serverError('No data responded by DrPublishAPI', $info['http_code']);
        }
        $out = new stdClass();
        $out->headers = $headerArray;
        $out->body = $body;
        return $out;
    }

    public static function resizeImage($currentSrc, $type, $imageServiceUrl, $imagePublishUrl)
    {
        $src = $currentSrc;
        $matches = mb_split('/', $src);
        $descriptorPos = count($matches) - 2;
        $matches[$descriptorPos] = $type;
        $newSrc = join('/', $matches);
        $newSrc = str_replace($imagePublishUrl, $imageServiceUrl, $newSrc);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $newSrc . '?return-properties');
        curl_setopt($ch, CURLOPT_COOKIESESSION, false);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        $info = curl_getinfo($ch);
        $body = substr($res, $info['header_size']);
        $props = json_decode($body, true);
        if (isset($props['error'])) {
            throw new DrPublishApiClientException('Error generating Image: ' . $props['error'], DrPublishApiClientException::IMAGE_CONVERTING_ERROR);
        }
        $props['src'] = str_replace($imageServiceUrl, $imagePublishUrl, $newSrc);
        return $props;
    }
}
