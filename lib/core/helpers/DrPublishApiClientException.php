<?php

class DrPublishApiClientException extends Exception
{
    private $requestUrl;

    const HTTP_ERROR = 1;
    const NO_DATA_ERROR = 3;
    const XML_ERROR = 4;
    const ARTICLE_NOT_FOUND_ERROR = 5;
    const IMAGE_CONVERTING_ERROR = 6;
    const UNAUTHORIZED_ACCESS_ERROR = 7;
    const UNKNOWN_ERROR = 8;

    public function setRequestUrl($url)
    {
        $this->requestUrl = $url;
    }

    public function getRequestUrl()
    {
        return $this->requestUrl;
    }
}