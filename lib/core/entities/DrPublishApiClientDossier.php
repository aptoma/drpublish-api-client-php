<?php

class DrPublishApiClientDossier extends DrPublishApiClientArticleEntity
{
    protected $id;
    protected $name;
    protected $parentId;
    protected $isMain;
    protected $parent;

    public function getParentId()
    {
        return $this->parentId;
    }

    public function getParent(DrPublishApiClient $dpClient)
    {
        return $dpClient->getCategory($this->parentId);
    }

    public function getIsMain()
    {
        return $this->isMain;
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