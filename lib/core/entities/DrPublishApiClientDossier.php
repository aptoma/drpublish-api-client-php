<?php

class DrPublishApiClientDossier extends DrPublishApiClientArticleEntity
{

    protected $id;
    protected $name;
    protected $parentId;
    protected $isMain;
    protected $parent;

    /**
     * Gets parent category id
     *
     * @return int
     */
    public function getParentId()
    {
        return $this->parentId;
    }

    /**
     * Gets the parent (if any)
     * @return DrPublishApiClientCategory
     */
    public function getParent(DrPublishApiClient $dpClient)
    {
        return $dpClient->getCategory($this->parentId);
    }

    /**
     * If "true" is returned, this category is the main one
     * @return boolean
     */
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

    /**
     * Magic method to convert the category to string (using its name)
     */
    public function __toString()
    {
        return $this->name;
    }


}