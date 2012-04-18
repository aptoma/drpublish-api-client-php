<?php
/**
 * DrPublishApiClientImage.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * DrPublishApiClientImage represents an image node embedded in a DrPublishApiClientArticleImageElement
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 967 2010-09-27 07:35:54Z stefan $
 * @author     stefan@aptoma.no
 */
class DrPublishApiClientImage extends DrPublishDomElement
{
	/**
	 * @return int
	 */
	public function getWidth()
	{
		return (int) $this->getAttribute('width');
	}

	/**
	 * @return int
	 */
	public function getHeight()
	{
		return (int) $this->getAttribute('height');
	}

	/**
	 * Alias for DrPublishApiClientImage::getSrc()
	 *
	 * @return string
	 */
	public function getUrl()
	{
		return  $this->getSrc();
	}

	/**
	 * Gets the souce attribute
	 *
	 * @return string
	 */
	public function getSrc()
	{
		return  $this->getAttribute('src');
	}
}