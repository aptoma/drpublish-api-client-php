<?php

class DrPublishApiClientArticleImageElement extends DrPublishDomElement
{

	protected $dpClientImage;

    protected $drPublishApiClientArticle;

	/**
	 * The class constructor registers the DOMElement and the entire related DOMDocument (needed for the to-string methods)
	 * @param DOMElement $domElement
	 * @param DOMDocument $dom
	 * @param DrPublishApiClient $dpClient
	 * @return void
	 */
	public function __construct(DrPublishDomElement $drPublishDomElement)
	{
        parent::__construct($drPublishDomElement->domElement);
		$this->dpClientImage = $this->getImage();
	}

    public function setDrPublishApiClientArticle(DrPublishApiClientArticle $drPublishApiClientArticle)
    {
        $this->drPublishApiClientArticle = $drPublishApiClientArticle;
    }

	/**
	 * Gets the image title
	 * @return string
	 */
	public function getTitle()
	{
        return $this->find("div[@class='dp-article-image-title'][1]/text()");
	}

	/**
	 * Gets the image description
	 * @return string
	 */
	public function getDescription()
	{
        return $this->find("div[@class='dp-article-image-description'][1]/text()");
	}

	/**
	 * Gets the image source
	 * @return string
	 */
	public function getSource()
	{
        return $this->find("div[@class='dp-article-image-source'][1]/text()");
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
		$imageServiceUrl = $this->drPublishApiClientArticle->getImageServiceUrl();
		$imagePublishUrl = $this->drPublishApiClientArticle->getImagePublishUrl();
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

        $imageElement = $this->domElement->getElementsByTagName('img')->item(0);
		if (empty($imageElement)) {
			return null;
		}
		return new DrPublishApiClientImage($imageElement);
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
