<?php
/**
 * DrPublishApiClientException.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * DrPublishApiClientHttpException is for handle HTTP errors occuring when "culing" DrPublish API
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 967 2010-09-27 07:35:54Z stefan $
 * @author     stefan@aptoma.no
 */
class DrPublishApiClientHttpException extends DrPublishApiClientException
{
	private $httpError;
	
	public function setHttpError($errorCode) {
		$this->httpError = $errorCode;
	}
	
	public function getHttpError() {
		return $this->httpError;
	}
}