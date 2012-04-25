<?php

class DrPublishApiClientSource extends DrPublishApiClientArticleEntity
{
	protected $id;
	protected $name;

    public function __toString()
    {
        return $this->name;
    }

}