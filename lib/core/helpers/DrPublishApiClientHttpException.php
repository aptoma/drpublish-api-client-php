<?php

class DrPublishApiClientHttpException extends DrPublishApiClientException
{
    private $httpError;

    public function setHttpError($errorCode)
    {
        $this->httpError = $errorCode;
    }

    public function getHttpError()
    {
        return $this->httpError;
    }
}