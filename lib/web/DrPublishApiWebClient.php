<?php

$dpwebdn = dirname(__FILE__);
require_once($dpwebdn . '/../core/DrPublishApiClient.php');
require_once($dpwebdn . '/entities/DrPublishApiWebClientArticle.php');
require_once($dpwebdn . '/entities/DrPublishApiWebClientAuthor.php');
require_once($dpwebdn . '/content/DrPublishApiWebClientImageElement.php');
unset($dpwebdn);

class DrPublishApiWebClient extends DrPublishApiClient
{

    public function __construct($url, $publicationName)
    {
        parent::__construct($url, $publicationName);
        $this->setMedium('web');
    }

    protected function createDrPublishApiClientArticle($article)
    {
        return new DrPublishApiWebClientArticle($article, $this);
    }

    protected function createDrPublishApiClientAuthor($author)
    {
        return new DrPublishApiWebClientAuthor($author);
    }
}