<?php

class DrPublishApiClientTag
{
    protected $id;
    protected $name;
    protected $data;
    protected $tagTypeId;
    protected $tagTypeName;

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
        $this->tagTypeId = $data->tagType->id;
        $this->tagTypeName = $data->tagType->name;
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

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    public function __toString()
    {
        return $this->name;
    }
}
