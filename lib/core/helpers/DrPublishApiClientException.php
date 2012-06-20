<?php

class DrPublishApiClientException extends Exception
{
    private $requestUrl;

    const HTTP_ERROR = 1;
    const PUBLICATION_ACCESS_ERROR = 2;
    const NO_DATA_ERROR = 3;
    const IMAGE_CONVERTING_ERROR = 4;
    const UNAUTHORIZED_ACCESS_ERROR = 5;
    const UNKNOWN_ERROR = 6;

    public function getCause()
    {
        $causes = array(
            1 => 'HTTP error',
            2 => 'publication access error',
            3 => 'no data error',
            4 => 'image converting error',
            5 => 'unauthorized access error',
            6 => 'unknown error'
        );
        if (isset($causes[$this->code])) {
            return  $causes[$this->code];
        } else {
            return 'unknown cause';
        }
    }

    public function setRequestUrl($url)
    {
        $this->requestUrl = $url;
    }

    public function getRequestUrl()
    {
        return $this->requestUrl;
    }
}