<?php
/**
 * DrPublishApiWebClient.php
 * @package    no.aptoma.drpublish.client.web
 */
/**
 * Includes
 */
$dpwebdn = dirname(__FILE__) ;
require_once($dpwebdn . '/../core/DrPublishApiClient.php');
require_once($dpwebdn . '/DrPublishApiWebClientArticle.php');
require_once($dpwebdn . '/DrPublishApiWebClientAuthor.php');
require_once($dpwebdn . '/DrPublishApiWebClientArticleElement.php');
require_once($dpwebdn . '/DrPublishApiWebClientImageElement.php');
unset($dpwebdn);
/**
 * DrPublishApiWebClient querys the DrPublish API and processes articles.
 * Build on the DrPublishApiClient implementation
 *
 * @package    no.aptoma.drpublish.client.web
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 970 2010-09-27 11:10:59Z stefan $
 * @author     stefan@aptoma.no
 *
 * @see DrPublishApiClient
 */
class DrPublishApiWebClient extends DrPublishApiClient
{
	/**
	 * Customizes DrPublishApiClient::createDrPublishApiClientArticle()
	 *
	 * @param DOMDocument $dom DOM transformed response from API
	 */
	protected function createDrPublishApiClientArticle($dom)
	{
		return new DrPublishApiWebClientArticle($dom, $this);
	}

	/**
	 * Creates a DrPublishApiWebClientAuthor from XML article
	 * @param DOMDocument $dom DOM transformed response from API
	 * @return DrPublishApiClientArticle
	 */
	protected function createDrPublishApiClientAuthor($dom)
	{
		$authorNode = $dom->documentElement->firstChild;
		$xpath = new DOMXPath($dom);
		$dpWebClientAuthor = new DrPublishApiWebClientAuthor($authorNode, $dom, $this, $xpath);
		return $dpWebClientAuthor;
	}
}