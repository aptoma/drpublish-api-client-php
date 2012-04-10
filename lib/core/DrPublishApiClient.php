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
require_once($dpcDirname . '/DrPublishApiClientList.php');
require_once($dpcDirname . '/DrPublishApiClientSearchList.php');
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
	protected $unitTestMode = false;
	protected $dom;
    protected $publicationName;
    public static $XMLNS_URI = 'http://aptoma.no/xml/drpublish';

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
		$url = $this->url . '/articles/'.$id . '.xml';
		$responseBody = trim($this->curl($url));
		if (empty($responseBody)) {
			throw new DrPublishApiClientException("No article data retreived for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
		}
		if (empty($responseBody)) {
			throw new DrPublishApiClientException('Empty aricle XML', DrPublishApiClientException::XML_ERROR);
		}
		$this->dom = new DOMDocument('1.0', 'UTF-8');
		$this->dom->loadXML($responseBody);
		$dpClientArticle = $this->createDrPublishApiClientArticle($this->dom);
		return $dpClientArticle;
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
		$url = $this->url . '/author/?id='.$id;
		$responseBody = trim($this->curl($url));
		if (empty($responseBody)) {
			throw new DrPublishApiClientException("No article data retreived for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
		}
		$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->loadXML($responseBody);
		$dpClientAuthor = $this->createDrPublishApiClientAuthor($dom);
		return $dpClientAuthor;
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
		$responseBody = trim($this->curl($url));
		if (empty($responseBody)) {
			throw new DrPublishApiClientException("No article data retreived for article-id='{$id}'", DrPublishApiClientException::NO_DATA_ERROR);
		}
		$dom = new DOMDocument('1.0', 'UTF-8');
		$dom->loadXML($responseBody);
		$dpClientCategory = $this->createDrPublishApiClientCategory($dom);
		return $dpClientCategory;
	}

	/**
	 * Get list of articles from server
	 *
	 * @param string $query
	 * @param int $limit
	 * @param int $offset
	 * @return DrPublishApiClientList list elements are DrPublishApiClientArticle objects
	 * @throws DrPublishApiClientException
	 */
	public function searchArticles($query, $limit = 10, $offset = 0)
	{
		$query = urlencode($query);
		$url = $this->url . '/articles/?publication=' . $this->publicationName . '&dynamicQuery='.$query.'&limit='.$limit.'&offset='.$offset;
		$articlesXml = $this->curl($url);
		$this->dom = new DOMDocument('1.0', 'UTF-8');
		$this->dom->loadXML($articlesXml);
		$xpath = new DOMXPath($this->dom);
		$xpath->registerNamespace('DrPublish', self::$XMLNS_URI);
		$articleNodes = $xpath->query('//DrPublish:article');
		$dpClientArticleList = new DrPublishApiClientSearchList();
		foreach($articleNodes as $articleNode) {
			$articleXml = $this->dom->saveXML($articleNode);
			$adom = new DOMDocument('1.0', 'UTF-8');
			$adom->loadXML('<DrPublish:drpublish xmlns:"' . self::$XMLNS_URI . '">' .$articleXml . '</DrPublish:drpublish>');
			$dpClientArticleList->add($this->createDrPublishApiClientArticle($adom));
		}
		
		$meta = $xpath -> query ( '//DrPublish:response/*' );
		foreach ( $meta as $metaNode ) {
		  switch ( $metaNode -> tagName ) {
		    case 'DrPublish:search-query':
		      $dpClientArticleList -> query = $metaNode -> textContent;
		      break;
		    case 'DrPublish:limit':
		      $dpClientArticleList -> limit = $metaNode -> textContent;
		      break;
		    case 'DrPublish:offset':
		      $dpClientArticleList -> offset = $metaNode -> textContent;
		      break;
		    case 'DrPublish:count':
		      $dpClientArticleList -> hits = $metaNode -> textContent;
		      break;
		    case 'DrPublish:total':
		      $dpClientArticleList -> total = $metaNode -> textContent;
		      break;
		    case 'DrPublish:time':
		      $dpClientArticleList -> time = $metaNode -> textContent;
		      break;
		  }
		}
		
		return $dpClientArticleList;
	}

	/**
	 * Get the image service url - used for image manipulation (resizing by now)
	 * @return string | null
	 */
	public function getImageServiceUrl()
	{
		$nodes = $this->dom->getElementsByTagNameNS(self::$XMLNS_URI, "imageServiceUrl");
		$node = $nodes->item(0);
		if (empty($node)) {
			return null;
		}
		return trim($node->textContent);
	}

	/**
	 * Get the image publish url - used for image manipulation (resizing by now)
	 * @return string | null
	 */
	public function getImagePublishUrl()
	{
		$nodes = $this->dom->getElementsByTagNameNS(self::$XMLNS_URI, "imagePublishUrl");
		$node = $nodes->item(0);
		if (empty($node)) {
			return null;
		}
		return trim($node->textContent);
	}

    public function getRequestUri()
    {
        return $this->requestUri;
    }

	/**
	 * Creates a DrPublishApiClientArticle from XML article
	 * This method can be overwritten by custom client
	 * @param DOMDocument $dom DOM transformed response from API
	 * @return DrPublishApiClientArticle
	 */
	protected function createDrPublishApiClientArticle($dom)
	{
		return new DrPublishApiClientArticle($dom, $this);
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
		if ($this->unitTestMode) $url .= '&unittest=true';
        $this->requestUri = $url;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_COOKIESESSION, false);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		$res = curl_exec($ch);
		$info = curl_getinfo($ch);
		$header = substr($res, 0, $info['header_size']);
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
		return $body;
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
