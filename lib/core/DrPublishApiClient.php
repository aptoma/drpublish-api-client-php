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
    private $protectedRequest = false;
    protected $apiKey;
    private $internalScopeClient = null;
    protected static $configs = null;
    private $curlInfo;

    public function __construct($url, $publicationName)
    {
        $this->url = $url;
        $this->publicationName = $publicationName;
        $this->readConfigs();
    }

    protected function readConfigs()
    {
        if (self::$configs !== null) {
            return;
        }
        $configs = array();
        $dir = dirname(__FILE__);
        require($dir . '/../config.default.php');
        if (file_exists($dir . '/../config.php')) {
            $tmpConfigs = $configs;
            require($dir . '/../config.php');
            $configs = array_merge($tmpConfigs, $configs);

        }
        self::$configs = $configs;
    }

    public static function getConfig($name)
    {
        if (isset(self::$configs[$name])) {
            return self::$configs[$name];
        }
    }

    public function setConfig($name, $value)
    {
        self::$configs[$name] = $value;
    }

    public function setCacheDir($path)
    {
        $this->setConfig('CACHE_DIR', $path);
    }

    public function internalScopeClient($apiKey = null, $protectedApiUrl = null)
    {
        if ($this->internalScopeClient !== null) {
            return $this->internalScopeClient;
        }
        if ($protectedApiUrl === null) {
            $protectedApiUrl = $this->url;
        }
        if ($apiKey === null) {
            if (empty($this->apiKey)) {
                throw new DrPublishApiClientException('Can not instantiate internal scope client without API key', DrPublishApiClientException::UNAUTHORIZED_ACCESS_ERROR);
            } else {
                $apiKey = $this->apiKey;
            }
        }
        $className = get_class($this);
        $internalScopeClient = new $className($protectedApiUrl, $this->publicationName);
        $internalScopeClient->setMedium($this->medium);
        $internalScopeClient->setDebugMode($this->debug);
        $internalScopeClient->setApiKey($apiKey);
        $internalScopeClient->setProtectedMode(true);
        $this->internalScopeClient = $internalScopeClient;
        return $internalScopeClient;
    }

    public function setApiKey($key)
    {
        $this->apiKey = $key;
    }

    protected function getApiKey()
    {
        return $this->apiKey;
    }

    public function setProtectedMode($bool)
    {
        $this->protectedRequest = $bool;
    }

    public function setApiUrl($url)
    {
        $this->url = $url;
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

    public function serverError($info, $body)
    {
        $statusCode = $info['http_code'];
        if (!empty($body)) {
            $response = json_decode($body);
            if (!empty($response)) {
                $message = urldecode($response->error->rawMessage);
                if (empty($message)) {
                    $message = $response->error->description;
                }
            } else {
                $message = 'Empty response';
            }
        } else {
            $message = 'Unknown error';
        }
        if ($statusCode == 404) {
            if (empty($body)) {
                $e = new DrPublishApiClientHttpException('Could not connect to DrPublish API server', DrPublishApiClientException::HTTP_ERROR);
            } else {
                $e = new DrPublishApiClientException($message, DrPublishApiClientException::NO_DATA_ERROR);
            }
        } else if ($statusCode == 401) {
            $e = new DrPublishApiClientException($message, DrPublishApiClientException::UNAUTHORIZED_ACCESS_ERROR);

        } else {
            $e = new DrPublishApiClientException($message, DrPublishApiClientException::UNKNOWN_ERROR);
        }
        $e->setRequestUrl($this->requestUri);
        throw $e;
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
        if ($query[0] == '?') {
            $query = substr($query, 1);
        }
        if ($query[0] != '&') {
            $query = '&' . $query;
        }
        $url = '/articles.json?publication=' . urlencode($this->publicationName) . $query;
        $response = $this->curl($url);
        $result = json_decode($response->body);
        //print_r($result);
        if (!isset($result->search)) {
            $search = new stdClass();
            $search->offset = $result->offset;
            $search->limit = $result->limit;
            $search->total = $result->total;
            $search->count = $result->count;
        } else {
            $search = $result->search;
        }
        $drPublishApiClientSearchList = new DrPublishApiClientSearchList($search, $response->headers);
        $articles = $result->items;
        foreach ($articles as $article) {
            $drPublishApiClientSearchList->add($this->createDrPublishApiClientArticle($article));
        }
        return $drPublishApiClientSearchList;
    }

    public function getArticlePreview($id, $apiKey, $internalScopeApiUrl)
    {
        $publicScopeApiUrl = $this->url;
        $params = '/articles/' . $id . '.json';
        try {
            $this->setProtectedMode(true);
            $this->setApiKey($apiKey);
            $this->url = $internalScopeApiUrl;
            $response = $this->curl($params);
            $this->setProtectedMode(false);
            $this->url = $publicScopeApiUrl;
        } catch (DrPublishApiClientException $e) {
            if ($e->getCode() === DrPublishApiClientException::NO_DATA_ERROR) {
                $this->url = $publicScopeApiUrl;
                $this->setProtectedMode(false);
                $response = $this->curl($params);
            } else {
                throw($e);
            }
        }
        $resultJson = $response->body;
        $result = json_decode($resultJson);
        if (empty($result)) {
            throw new DrPublishApiClientException("No article data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientArticle($result);
    }

    public function getArticle($id)
    {
        $url = '/articles/' . $id . '.json';
        $response = $this->curl($url);
        $resultJson = $response->body;
        $result = json_decode($resultJson);
        if (empty($result)) {
            $e = new DrPublishApiClientException("No article data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
            $e->setRequestUrl($this->requestUri);
            throw $e;
        }
        if (!isset($result->meta->publication->name) || $result->meta->publication->name != $this->publicationName) {
            $e = new DrPublishApiClientException("Article article-id='{$id}' is not connected to publication '{$this->publicationName}'", DrPublishApiClientException:: PUBLICATION_ACCESS_ERROR);
            $e->setRequestUrl($this->requestUri);
            throw $e;
        }
        return $this->createDrPublishApiClientArticle($result);
    }

    public function searchAuthors($query, $limit = 5, $offset = 0)
    {
        $query = urldecode($query);
        $url = '/users.json?' . $query . '&offset=' . $offset . '&limit=' . $limit;
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
        $url = '/users/' . $id . '.json';
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        if (empty($responseObject)) {
            throw new DrPublishApiClientException("No or invalid author data retrieved for author id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientAuthor($responseObject);
    }

    public function searchTags($query, $limit = 5, $offset = 0)
    {
        $query = urldecode($query);
        $url = '/tags.json?' . $query . '&offset=' . $offset . '&limit=' . $limit;
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
        $url = '/tags/' . $id . '.json';
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        if (empty($responseObject)) {
            throw new DrPublishApiClientException("No or invalid author data retrieved for tag id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        $dpClientTag = $this->createDrPublishApiClientTag($responseObject);
        return $dpClientTag;
    }

    public function searchCategories($query, $limit = 5, $offset = 0)
    {
        $url = '/categories.json?' . $query . '&offset=' . $offset . '&limit=' . $limit;
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
        $url = '/categories/' . $id . '.json';
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        if (empty($responseObject)) {
            throw new DrPublishApiClientException("No article data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientCategory($responseObject);
    }

    public function searchDossiers($query, $limit = 5, $offset = 0)
    {
        $url = '/dossiers.json?' . $query . '&offset=' . $offset . '&limit=' . $limit;
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
        $url = '/dossiers/' . $id . '.json';
        $response = $this->curl($url);
        $responseObject = json_decode($response->body);
        if (empty($responseObject)) {
            throw new DrPublishApiClientException("No article data retrieved for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
        }
        return $this->createDrPublishApiClientDossier($responseObject);
    }

    public function searchSources($query, $limit = 5, $offset = 0)
    {
        $url = '/sources.json?' . $query . '&offset=' . $offset . '&limit=' . $limit;
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
        $url = '/sources/' . $id . '.json';
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

    public function createDrPublishApiClientCategory($category)
    {
        return new DrPublishApiClientCategory($category, $this);
    }

    public static function writeCache($identifier, $data)
    {
        $cacheFile = self::cacheDirGen($identifier, true);
        if ($cacheFile !== false) {
            file_put_contents($cacheFile . '.tmp', serialize($data));
            rename($cacheFile . '.tmp', $cacheFile);
        }
    }

    public static function readCache($identifier)
    {
        $cacheFile = self::cacheDirGen($identifier);
        if (file_exists($cacheFile)) {
            return unserialize(file_get_contents($cacheFile));
        }
        return false;
    }

    private static function cacheDirGen($identifier, $write = false)
    {
        $baseDir = self::getConfig('CACHE_DIR');
        $id = md5($identifier);
        $dirString = $id[0] . $id[1] . '/' . $id[2] . $id[3] . '/' . $id[4] . $id[5];
        $cacheDir = $baseDir . '/' . $dirString;
        if ($write === true) {
            if (!is_writable($baseDir)) {
                trigger_error("Data cache directory '{$baseDir}' is not writable. DrPublishApiClient can't cache your data!", E_USER_WARNING);
                return false;
            } else {
                if (!is_dir($cacheDir)) {
                    umask(0000);
                    mkdir($cacheDir, 0777, true);
                }
            }
        }
        return $cacheDir . '/' . $id . '.dat';
    }

    protected function curl($params)
    {
        $params = str_replace(' ', '+', $params);
        if ($this->protectedRequest) {
            $url = $this->url . $params;
            $url .= strpos($params, '?') === false ? '?' : '&';
            $url .= 'scope=internal&apikey=' . $this->apiKey;
        } else {
            $url = $this->url . $params;
        }

        $q_pos = mb_strpos($url, '?');
        if ($q_pos > 0) {
            $pre_url = mb_substr($url, 0, $q_pos);
            $split = mb_substr($url, $q_pos+1);
            $split = explode('&', $split);
            $params = array();
            foreach ($split as $sp) {
                $s = explode('=', $sp);
                if (isset($s[1])) {
                    $params[urldecode($s[0])] = urldecode(trim($s[1]));
                } else {
                    $params[urldecode($s[0])] = true;
                }
            }
            $params = http_build_query($params);
            $url = $pre_url.'?'.$params;
        }

        $this->requestUri = $url;
        if ($this->debug) {
            $url .= strpos($url, '?') === false ? '?' : '&';
            $url .= 'debug';
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_COOKIESESSION, false);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        $res = curl_exec($ch);
        $info = curl_getinfo($ch);
        $this->curlInfo = $info;

        //$e = curl_error($ch);
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
        if ($info['http_code'] != 200) {
            $this->serverError($info, $body);
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
        $cachingEnabled = self::getConfig('ENABLE_IMAGE_DATA_CACHING');
        if ($cachingEnabled) {
            $cacheIdentifier = $currentSrc . $type;
            $cacheData = self::readCache($cacheIdentifier);
            if ($cacheData !== false) {
                return $cacheData;
            }

        }
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
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        $info = curl_getinfo($ch);
        $body = substr($res, $info['header_size']);
        $props = json_decode($body, true);
        if (isset($props['error'])) {
            throw new DrPublishApiClientException('Error generating Image: ' . $props['error'], DrPublishApiClientException::IMAGE_CONVERTING_ERROR);
        }
        $props['src'] = str_replace($imageServiceUrl, $imagePublishUrl, $newSrc);
        if ($cachingEnabled) {
            self::writeCache($cacheIdentifier, $props);
        }
        return $props;
    }

    public function getCurlInfo()
    {
        return $this->curlInfo;
    }
}
