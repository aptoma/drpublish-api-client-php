<?php
class DrPublishApiClientCategory extends DrPublishApiClientArticleEntity
{
    protected $id;
    protected $name;
    protected $parentId;
    protected $parentName;
    protected $publicationId;
    protected $isMain;
    protected $parent;

    public function __construct($data)
    {
        parent::__construct($data);
    }

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