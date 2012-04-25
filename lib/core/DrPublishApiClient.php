<?php

$dpcDirname = dirname(__FILE__);
require_once($dpcDirname . '/helpers/DrPublishApiClientList.php');
require_once($dpcDirname . '/helpers/DrPublishApiClientSearchList.php');
require_once($dpcDirname . '/helpers/DrPublishDomElementList.php');
require_once($dpcDirname . '/helpers/DrPublishApiClientException.php');
require_once($dpcDirname . '/helpers/DrPublishApiClientHttpException.php');
require_once($dpcDirname . '/dom/DrPublishDomElement.php');
require_once($dpcDirname . '/dom/DrPublishDomText.php');
require_once($dpcDirname . '/entities/DrPublishApiClientArticleEntity.php');
require_once($dpcDirname . '/entities/DrPublishApiClientArticle.php');
require_once($dpcDirname . '/entities/DrPublishApiClientAuthor.php');
require_once($dpcDirname . '/entities/DrPublishApiClientCategory.php');
require_once($dpcDirname . '/entities/DrPublishApiClientTag.php');
require_once($dpcDirname . '/entities/DrPublishApiClientDossier.php');
require_once($dpcDirname . '/entities/DrPublishApiClientSource.php');
require_once($dpcDirname . '/content/DrPublishApiClientArticleElement.php');
require_once($dpcDirname . '/content/DrPublishApiClientXmlElement.php');
require_once($dpcDirname . '/content/DrPublishApiClientTextElement.php');
require_once($dpcDirname . '/content/DrPublishApiClientArticleImageElement.php');
require_once($dpcDirname . '/content/DrPublishApiClientImage.php');
require_once($dpcDirname . '/content/DrPublishApiClientPhotographer.php');
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

    /**
     * Constructor for this class
     *
     * @param string $url URL to the Dr.Publish API
     * @return void
     */
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

    /**
     * Internal used to unit test the client
     */
    public function setUnitTestMode()
    {
        $this->unitTestMode = true;
    }

    /**
     * Internal used to unit test the client
     * @return boolean
     */
    public function getUnitTestMode()
    {
        return $this->unitTestMode;
    }

    /**
     * Check if request is made from preview (backend)
     *
     * @return boolean
     */
    protected function _isPreviewRequest()
    {
        return isset($_REQUEST['dp-preview']);
    }

    /**
     * Handle communications errors
     *
     * @param string $msg
     * @return void
     */
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

    /**
     * Get list of articles from server
     *
     * @param string $query
     * @param array options
     * @return DrPublishApiClientList list elements are DrPublishApiClientArticle objects
     * @throws DrPublishApiClientException
     */
    public function searchArticles($query, $options = array())
    {
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

    /**
     * Get article from server
     *
     * @param int $id
     * @return DrPublishApiClientArticle
     * @throws DrPublishApiClientException
     */
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

    public function searchAuthors($query, $offset = 0, $limit = 5)
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

    public function searchTags($query, $offset = 0, $limit = 5)
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

    public function searchCategories($query, $offset = 0, $limit = 5)
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
        if (empty($response->body)) {
            throw new DrPublishApiClientException("No article data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientCategory($response->body);
    }

    public function searchDossiers($query, $offset = 0, $limit = 5)
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
        if (empty($response->body)) {
            throw new DrPublishApiClientException("No article data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientDossier($response->body);
    }

    public function searchSources($query, $offset = 0, $limit = 5)
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
        if (empty($response->body)) {
            throw new DrPublishApiClientException("No article data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientSource($response->body);
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
        $this->requestUri = urlencode($url);
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
        $res = curl_exec($ch);
        $info = curl_getinfo($ch);
        //if ($this->debug) {
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
        //}
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

    /**
     * Create a resized image on harddisk
     *
     * @param string $currentSrc current image url (before resizing)
     * @param string $type Image size descriptor
     * @param string $imageServiceUrl DrPublish backoffice URL base, the one where the image resizer is located
     * @param string $imagePublishUrl Out URL base for the generated image
     * @throws DrPublishApiClientException;
     */
    public static function resizeImage($currentSrc, $type, $imageServiceUrl, $imagePublishUrl)
    {
        $src = $currentSrc;
        $matches = mb_split('/', $src);
        $descriptorPos = count($matches) - 2;
        //$descriptor = $matches[$descriptorPos];
        $matches[$descriptorPos] = $type;
        $newSrc = join('/', $matches);
        // swap publish URL with service URL
        $newSrc = str_replace($imagePublishUrl, $imageServiceUrl, $newSrc);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $newSrc . '?return-properties');
        curl_setopt($ch, CURLOPT_COOKIESESSION, false);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $res = curl_exec($ch);
        $info = curl_getinfo($ch);
        //$header = substr($res, 0, $info['header_size']);
        $body = substr($res, $info['header_size']);
        curl_close($ch);
        $props = json_decode($body, true);
        if (isset($props['error'])) {
            throw new DrPublishApiClientException('Error generating Image: ' . $props['error'], DrPublishApiClientException::IMAGE_CONVERTING_ERROR);
        }
        // swap back to publish URL
        $props['src'] = str_replace($imageServiceUrl, $imagePublishUrl, $newSrc);
        return $props;
    }
}
