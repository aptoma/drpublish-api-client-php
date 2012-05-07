<?php

class DrPublishApiClientSource extends DrPublishApiClientArticleEntity
{
	protected $id;
	protected $name;

    public function __toString()
    {
        return isset($this->name) ? $this->name : '';
    }

}