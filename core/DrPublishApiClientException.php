<?php
/**
 * DrPublishApiClientException.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * DrPublishApiClientException is for error handling in DrPublishApiClient
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 967 2010-09-27 07:35:54Z stefan $
 * @author     stefan@aptoma.no
 */
class DrPublishApiClientException extends Exception
{
	const HTTP_ERROR = 1;
	const NO_DATA_ERROR = 3;
	const XML_ERROR = 3;
	const ARTICLE_NOT_FOUND_ERROR = 4;
	const IMAGE_CONVERTING_ERROR = 5;
}