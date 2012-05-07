<?php

class DrPublishApiClientDossier extends DrPublishApiClientArticleEntity
{
    protected $id;
    protected $name;
    protected $parentId;
    protected $parentName;
    protected $publicationId;
    protected $priority;
    protected $originalId;
    protected $deleted;
    protected $start;
    protected $expire;
    protected $parent;

    public function getParent(DrPublishApiClient $dpClient)
    {
        return $dpClient->getCategory($this->parentId);
    }

    public function getParentName()
    {
        if ($this->parentId == 0) {
            return '';
        }
        return $this->parentName;
    }

    public function __toString()
    {
        return isset($this->name) ? $this->name : '';
    }
}