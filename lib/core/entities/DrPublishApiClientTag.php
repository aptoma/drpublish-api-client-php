<?php

class DrPublishApiClientTag extends DrPublishApiClientArticleEntity
{
    protected $id;
    protected $name;
    protected $data;
    protected $tagTypeId;
    protected $tagTypeName;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->tagTypeId = $data->tagType->id;
        $this->tagTypeName = $data->tagType->name;
    }

    /**
     * @return string
     */
    public function getTagTypeName()
    {
        return $this->tagTypeName;
    }

    /**
     * @return string
     */
    public function getTagTypeId()
    {
        return $this->tagTypeId;
    }

    /**
     * @return string
     */
    public function getData()
    {
        return $this->data;
    }

    public function __toString()
    {
        return $this->name;
    }
}
