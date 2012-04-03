<?php
/**
 * DrPublishApiClientArticleImageElement.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * DrPublishApiClientArticleElement extends th DrPublishApiClientArticleElement class and  represents a DPImage DOM node.
 * DPImages are elements inserted in an article by using images plugin
 * The class provides methods for acessing element attributes and
 *	- getting and manipulating (resizing) the image element
 *	- getting the photographer as object
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 967 2010-09-27 07:35:54Z stefan $
 * @author     stefan@aptoma.no
 *
 * @see DrPublishClientArticleElement
 */
class DrPublishApiClientArticleImageElement extends DrPublishApiClientArticleElement
{

	protected $dpClientImage;

	/**
	 * The class constructor registers the DOMElement and the entire related DOMDocument (needed for the to-string methods)
	 * @param DOMElement $domElement
	 * @param DOMDocument $dom
	 * @param DrPublishApiClient $dpClient
	 * @return void
	 */
	public function __construct(DOMElement $domElement, DOMDocument $dom, DrPublishApiClient $dpClient, DOMXPath $xpath)
	{
		parent::__construct($domElement, $dom, $dpClient, $xpath);
		$this->dpClientImage = $this->getImage();
	}

	/**
	 * Gets the image title
	 * @return string
	 */
	public function getTitle()
	{
		return urldecode($this->getAttribute('data-image-title'));
	}

	/**
	 * Gets the image description
	 * @return string
	 */
	public function getDescription()
	{
		return urldecode($this->getAttribute('data-image-description'));
	}

	/**
	 * Gets the image source
	 * @return string
	 */
	public function getSource()
	{
		return urldecode($this->getAttribute('data-source-name'));
	}
	
	/**
	 * Create a resized image on harddisk
	 *
	 * @param string $type image type as mapped up in settings.php (thumbnail, main, illustration etc);
	 * @return DrPublishApiClientImage
	 * @throw DrPublishApiClientException
	 */
	public function getResizedImage($type) {
		$imageElement = $this->dpClientImage;
		if (empty($imageElement)) {
			return null;
		}
		$imageServiceUrl = $this->dpClient->getImageServiceUrl();
		$imagePublishUrl = $this->dpClient->getImagePublishUrl();
		$currentSrc = $imageElement->getAttribute('src');
		try {
			$properties = DrPublishApiClient::resizeImage($currentSrc, $type, $imageServiceUrl, $imagePublishUrl);
		} catch (DrPublishApiClientException $e) {
			throw $e;
		}
		$imageElement->setAttribute('src', $properties['src']);
    if ( array_key_exists ( 'width', $properties ) ) {
      $imageElement->setAttribute('width', $properties['width']);
    }
    if ( array_key_exists ( 'height', $properties ) ) {
      $imageElement->setAttribute('height', $properties['height']);
    }
		return $imageElement;
	}
	

	/**
	 * Returns the image element (img tag) of this DPImage
	 *
	 * @return DrPublishApiClientImage
	 */
	public function getImage()
	{
		$xpath = new DOMXPath($this->dom);
		$domNodes = $xpath->query('./img[1]|./*/img[1]|./*/*/img[1]', $this->domElement);
		$imageElement = $domNodes->item(0);
		if (empty($imageElement)) {
			return null;
		}
		return new DrPublishApiClientImage($imageElement, $this->dom, $this->dpClient, $this->xpath);
	}

	/**
	 * Gets the photographer (author) of this DPImage
	 * @return DrPublishApiClientPhotographer
	 */
	public function getPhotographer()
	{
		$photographer = new DrPublishApiClientPhotographer();
		$photographer->setId($this->getAttribute('data-author-id'));
		$photographer->setName(urldecode($this->getAttribute('data-author-name')));
		$photographer->setUsername($this->getAttribute('data-author-username'));
		$photographer->setEmail($this->getAttribute('data-author-email'));
		return $photographer;
	}
}
