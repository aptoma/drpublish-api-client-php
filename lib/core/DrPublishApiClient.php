<?php
/**
 * DrPublishApiClient.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * Includes
 */
$dpcDirname = dirname(__FILE__);
require_once($dpcDirname . '/DrPublishApiClientException.php');
require_once($dpcDirname . '/DrPublishApiClientHttpException.php');
require_once($dpcDirname . '/DrPublishApiClientConfig.php');
require_once($dpcDirname . '/DrPublishApiClientArticle.php');
require_once($dpcDirname . '/DrPublishApiClientArticleElement.php');
require_once($dpcDirname . '/DrPublishApiClientXmlElement.php');
require_once($dpcDirname . '/DrPublishApiClientTextElement.php');
require_once($dpcDirname . '/DrPublishApiClientList.php');
require_once($dpcDirname . '/DrPublishApiClientSearchList.php');
require_once($dpcDirname . '/DrPublishDomElementList.php');
require_once($dpcDirname . '/DrPublishDomElement.php');
require_once($dpcDirname . '/DrPublishDomText.php');
require_once($dpcDirname . '/DrPublishApiClientArticleImageElement.php');
require_once($dpcDirname . '/DrPublishApiClientAuthor.php');
require_once($dpcDirname . '/DrPublishApiClientCategory.php');
require_once($dpcDirname . '/DrPublishApiClientTag.php');
require_once($dpcDirname . '/DrPublishApiClientSource.php');
require_once($dpcDirname . '/DrPublishApiClientImage.php');
require_once($dpcDirname . '/DrPublishApiClientPhotographer.php');

unset($dpcDirname);

/**
 * DrPublishApiClient is an example of using the DrPublish API.
 * Refer to the developer documentation in DrPlublish backoffice for explanation
 * and introduction to how to use DrPublishApiClient.
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id$
 * @author     patrik@aptoma.no, stefan@aptoma.no
 */
class DrPublishApiClient
{
	protected $url;
    protected $requestUri;
    protected $searchQueryUrl;
	protected $unitTestMode = false;
    protected $debug = false;
	protected $dom;
    protected $publicationName;
    public static $XMLNS_URI = 'http://aptoma.no/xml/drpublish';
    protected $medium;

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
        $this->medium = 'web';
	}

    public function setMedium($medium) {
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
	protected function _isPreviewRequest() {
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
	 * Get article from server
	 *
	 * @param int $id
	 * @return DrPublishApiClientArticle
	 * @throws DrPublishApiClientException
	 */
	public function getArticle($id)
	{
		$url = $this->url . '/articles/'.$id . '.json';
        $response = $this->curl($url);
        $resultJson = $response->body;
          $result = json_decode($resultJson);
		if (empty($result)) {
			throw new DrPublishApiClientException("No article data retreived for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
		}
		$dpClientArticle = $this->createDrPublishApiClientArticle($result);
		return $dpClientArticle;
	}

    public function searchAuthors($query, $offset = 0, $limit = 5)
    {
        $query = urldecode($query);
        $url = $this->url . '/users.json?' . $query . '&offset=' . $offset . '&limit=' . $limit;
        $response = trim($this->curl($url));
        $responseObject = json_decode($response->body);
        $list = new DrPublishApiClientSearchList($responseObject->search);
        if (!empty($responseObject)) {
            $list->offset = $responseObject->offset;
            $list->limit = $responseObject->limit;
            $list->hits = $responseObject->count;
            $list->total = $responseObject->total;
            $list->query = $this->requestUri;
            $authors = $responseObject->items;
            foreach ($authors as $author) {
                $author = new DrPublishApiClientAuthor($author);
                $list->add($author);
            }
        }
        return ($list);
    }

	/**
	 * Get author from server
	 *
	 * @param int $id
	 * @return DrPublishApiClientAuthor
	 * @throws DrPublishApiClientException
	 */
	public function getAuthor($id)
	{
		$url = $this->url . '/users/'.$id . '.json';
		$response = trim($this->curl($url));
         $responseObject = json_decode($response->body);
		if (empty($responseObject)) {
			throw new DrPublishApiClientException("No or invalid author data retreived for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
		}
		$dpClientAuthor = new DrPublishApiClientAuthor($responseObject);
		return $dpClientAuthor;
	}


    public function searchTags($query, $offset = 0, $limit = 5)
    {
        $query = urldecode($query);
        $url = $this->url . '/tags.json?' . $query . '&offset=' . $offset . '&limit=' . $limit;
        $response = trim($this->curl($url));
        $responseObject = json_decode($response->body);
        $list = new DrPublishApiClientSearchList($responseObject->search);
        if (!empty($responseObject)) {
            $list->offset = $responseObject->offset;
            $list->limit = $responseObject->limit;
            $list->hits = $responseObject->count;
            $list->total = $responseObject->total;
            $list->query = $this->requestUri;
            $tags = $responseObject->items;
            foreach ($tags as $tag) {
                $tag = new DrPublishApiClientTag($tag);
                $list->add($tag);
            }
        }
        return ($list);
    }


    public function getTag($id)
    	{
    		$url = $this->url . '/tags/'.$id . '.json';
    		$response = $this->curl($url);
             $responseObject = json_decode($response->body);
    		if (empty($responseObject)) {
    			throw new DrPublishApiClientException("No or invalid author data retreived for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
    		}
    		$dpClientTag = new DrPublishApiClientTag($responseObject);
    		return $dpClientTag;
    	}



	/**
	 * Get category from server
	 *
	 * @param int $id
	 * @return DrPublishApiClientAuthor
	 * @throws DrPublishApiClientException
	 */
	public function getCategory($id)
	{
		$url = $this->url . '/category/?id='.$id;
		$response = $this->curl($url);
		if (empty($response->body)) {
			throw new DrPublishApiClientException("No article data retreived for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
		}
		$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->loadXML($response->body);
		$dpClientCategory = $this->createDrPublishApiClientCategory($dom);
		return $dpClientCategory;
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
                $query .=  "&{$key}={$value}";
            }
        }
		$url = $this->url . '/articles.json?publication=' . $this->publicationName . ''.$query ;
		$response = $this->curl($url);
        $result = json_decode($response->body);
//		$this->dom = new DOMDocument('1.0', 'UTF-8');
//		$this->dom->loadXML($articlesXml);
//		$xpath = new DOMXPath($this->dom);

       // $searchMeta->links = $response->headers['Link'];

//		$xpath->registerNamespace('DrPublish', self::$XMLNS_URI);
//		$articleNodes = $xpath->query('//DrPublish:response/DrPublish:article');

		$drPublishApiClientSearchList = new DrPublishApiClientSearchList($result->search, $response->headers);

        $articles = $result->items;
		foreach($articles as $article) {
           // print_r($article->meta);
            $drPublishApiClientArticle = $this->createDrPublishApiClientArticle($article);
            $drPublishApiClientSearchList->add($drPublishApiClientArticle);
//            print "<pre>";
//            print "\nid: ";
//            print_r ($drPublishApiClientArticle->getId());
//            print "\npublished: ";
//            print_r ($drPublishApiClientArticle->getPublished());
//            print "<pre>";
//            print "\nenable comments: ";
//            print_r ($drPublishApiClientArticle->getEnableComments());
//            print "categories: \n";
//            print_r ($drPublishApiClientArticle->getCategories());
//            print "source: \n";
//            print_r ($drPublishApiClientArticle->getSource());
//            print "title: \n";
//            print_r ($drPublishApiClientArticle->getBodyText());
//            print "leadAsset: \n";
 //           print ($drPublishApiClientArticle->getLeadAsset()->find('div[@class="dp-article-image-description"]'));
//exit;
			//$articleXml = $this->dom->saveXML($articleNode);
           // $articleXml = '<DrPublish:article xmlns:DrPublish="' . self::$XMLNS_URI . '">' .$articleXml . '</DrPublish:article>';
			//$adom = new DOMDocument('1.0', 'UTF-8');
			//$adom->loadXML($articleXml);
			//$dpClientArticleList->add($this->createDrPublishApiClientArticle($adom));
		}
//
//		$meta = $xpath->query ('DrPublish:response/DrPublish:limit|DrPublish:total[1]|DrPublish:offset[1]|DrPublish:count[1]' );
//		foreach ( $meta as $metaNode ) {
//		  switch ( $metaNode->tagName ) {
//		    case 'DrPublish:limit':
//		      $dpClientArticleList->limit = $metaNode->textContent;
//		      break;
//		    case 'DrPublish:offset':
//		      $dpClientArticleList->offset = $metaNode->textContent;
//		      break;
//		    case 'DrPublish:count':
//		      $dpClientArticleList->hits = $metaNode->textContent;
//		      break;
//		    case 'DrPublish:total':
//		      $dpClientArticleList->total = $metaNode->textContent;
//		      break;
//		    case 'DrPublish:time':
//		      $dpClientArticleList -> time = $metaNode -> textContent;
//		      break;
//		  }
//		}
		//var_dump($drPublishApiClientSearchList->getSearchProperty('limit'));
		return $drPublishApiClientSearchList;
	}



    public function getRequestUri()
    {
        return $this->requestUri;
    }

    public function getSearchQueryUri()
    {
        return $this->searchQueryUrl;
    }

	/**
	 * Creates a DrPublishApiClientArticle from XML article
	 * This method can be overwritten by custom client
	 * @param DOMDocument $dom DOM transformed response from API
	 * @return DrPublishApiClientArticle
	 */
	protected function createDrPublishApiClientArticle($article)
	{
		return new DrPublishApiClientArticle($article, $this);
	}

	/**
	 * Creates a DrPublishApiClientAuthor from XML article
	 * This method can be overwritten by custom client
	 * @param DOMDocument $dom DOM transformed response from API
	 * @return DrPublishApiClientArticle
	 */
	protected function createDrPublishApiClientAuthor($dom)
	{
		$authorNode = getElementsByTagNameNS(self::$XMLNS_URI, "author")->item(0);
		$xpath = new DOMXPath($dom);
		$dpClientAuthor = new DrPublishApiClientAuthor($authorNode, $dom, $this, $xpath);
		$dpClientAuthor->setId($dpClientAuthor->getProperty('id'));
		$dpClientAuthor->setFullName($dpClientAuthor->getProperty('fullname'));
		$dpClientAuthor->setUserName($dpClientAuthor->getProperty('username'));
		$dpClientAuthor->setEmail($dpClientAuthor->getProperty('email'));
		return $dpClientAuthor;
	}

	/**
	 * Creates a DrPublishApiClientAuthor from XML article
	 * This method can be overwritten by custom client
	 * @param DOMDocument $dom DOM transformed response from API
	 * @return DrPublishApiClientArticle
	 */
	protected function createDrPublishApiClientCategory($dom)
	{
		$catgeoryNode = $dom->getElementsByTagNameNS(self::$XMLNS_URI, "category")->item(0);
		$xpath = new DOMXPath($dom);
		$dpClientCategory = new DrPublishApiClientCategory($catgeoryNode, $dom, $this, $xpath);
		$dpClientCategory->setId($catgeoryNode->getAttribute('id'));
		$dpClientCategory->setParentId($catgeoryNode->getAttribute('parentId'));
		$dpClientCategory->setName($catgeoryNode->nodeValue);
		return $dpClientCategory;
	}

	/**
	 * Auxiliary function for retrieving data from DrPublish API
	 *
	 * @param string $url URL to DrPublish installation
	 * @return string Response body
	 */
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
             for($i=1; $i< count($split)-1; $i=$i+2) {
                 $headerArray[trim($split[$i])] = $split[$i+1];
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
	public static function resizeImage($currentSrc, $type, $imageServiceUrl, $imagePublishUrl) {
		$src = $currentSrc;
		$matches = mb_split('/', $src);
		$descriptorPos = count($matches)-2;
		$descriptor = $matches[$descriptorPos];
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
		$header = substr($res, 0, $info['header_size']);
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
