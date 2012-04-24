<?php

class DrPublishApiClientDossier
{

    protected $id;
    protected $name;
    protected $parentId;
    protected $isMain;
    protected $parent;

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

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
    public function getParent()
    {
        return $this->dpClient->getCategory($this->parentId);
    }

    /**
     * If "true" is returned, this category is the main one
     * @return boolean
     */
    public function getIsMain()
    {
        return $this->isMain;
    }

    /**
     * Magic method to convert the category to string (using its name)
     */
    public function __toString()
    {
        return $this->name;
    }


}