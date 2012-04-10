<?php
/**
 * DrPublishApiWebClientImageElement.php
 * @package    no.aptoma.drpublish.client.web
 */
/**
 * DrPublishApiWebClientImageElement is a customized version of DrPublishApiClientArticleImageElement
 *
 * @package    no.aptoma.drpublish.client.web
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 970 2010-09-27 11:10:59Z stefan $
 * @author     stefan@aptoma.no
 *
 * @see DrPublishApiClientArticleImageElement
 */
class DrPublishApiWebClientImageElement extends DrPublishApiClientArticleImageElement
{
	/**
	 * Gets a thumbnail version of the image
	 *
	 * @param string $size Box dimenision or predefined literal
	 * @return DrPublishApiClientImage
	 */
	public function getThumbnail($size = 100)
	{
		return $this->getResizedImage($size);
	}
	
	/**
	 * Gets the image title
	 * @return string
	 */
	public function getTitle()
	{
		$dpArticleElement = $this->getElement('descendant::*[@class="dp-article-image-title"]');
		return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
	}

	/**
	 * Gets the image description
	 * @return string
	 */
	public function getDescription()
	{
		$dpArticleElement = $this->getElement('descendant::*[@class="dp-article-image-description"]');
		return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
	}

	/**
	 * Gets the image byline label
	 * @return string
	 */
	public function getBylineLabel()
	{
		$dpArticleElement = $this->getElement('descendant::*[@class="dp-article-byline-label"]');
		return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
	}
	
	/**
	 * Gets the image source
	 * @return string
	 */
	public function getAuthor()
	{
		$dpArticleElement = $this->getElement('descendant::*[@class="dp-article-image-author"]');
		return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
	}
	
	/**
	 * Gets the image source
	 * @return string
	 */
	public function getSource()
	{
		$dpArticleElement = $this->getElement('descendant::*[@class="dp-article-image-source"]');
		return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
	}

}