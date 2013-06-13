<?php

$dpwebdn = dirname(__FILE__);
require($dpwebdn . '/../core/DrPublishApiClient.php');
require($dpwebdn . '/entities/DrPublishApiWebClientArticle.php');
require($dpwebdn . '/entities/DrPublishApiWebClientAuthor.php');
require($dpwebdn . '/content/DrPublishApiWebClientImageElement.php');
unset($dpwebdn);

class DrPublishApiWebClient extends DrPublishApiClient
{

    public function __construct($url, $publicationName, $config = null)
    {
        parent::__construct($url, $publicationName, $config);

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
