<?php

class DrPublishApiClientCategory
{

    protected $id;
    protected $name;
    protected $parentId;
    protected $isMain;
    protected $parent;
    protected $dpClient;

    public function __construct($data, $dpClient)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
        $this->dpClient = $dpClient;
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