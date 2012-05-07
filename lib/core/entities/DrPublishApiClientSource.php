<?php

class DrPublishApiClientSource extends DrPublishApiClientArticleEntity
{
	protected $id;
	protected $name;
    protected $publicationId;

    public function __toString()
    {
        return isset($this->name) ? $this->name : '';
    }

}