<?php

$dpwebdn = dirname(__FILE__);
require_once($dpwebdn . '/../core/DrPublishApiClient.php');
require_once($dpwebdn . '/DrPublishApiWebClientArticle.php');
require_once($dpwebdn . '/DrPublishApiWebClientAuthor.php');
require_once($dpwebdn . '/DrPublishApiWebClientArticleElement.php');
require_once($dpwebdn . '/DrPublishApiWebClientImageElement.php');
unset($dpwebdn);

class DrPublishApiWebClient extends DrPublishApiClient
{

    public function __construct($url, $publicationName)
    {
        parent::__construct($url, $publicationName);
        $this->medium = 'web';
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