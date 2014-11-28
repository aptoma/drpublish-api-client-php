<?php

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
