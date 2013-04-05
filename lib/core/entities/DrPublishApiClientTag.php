<?php

class DrPublishApiClientTag extends DrPublishApiClientArticleEntity
{
    protected $id;
    protected $name;
    protected $content;
    protected $data;
    protected $tagTypeId;
    protected $tagTypeName;

    public function __construct($data)
    {
        parent::__construct($data);

        if (!empty($data->tagType->id)) {
            $this->tagTypeId = $data->tagType->id;
        }

        if (!empty($data->tagType->name)) {
            $this->tagTypeName = $data->tagType->name;
        }
    }

    public function getTagTypeName()
    {
        return $this->tagTypeName;
    }

    public function getTagTypeId()
    {
        return $this->tagTypeId;
    }

    public function __toString()
    {
        return isset($this->name) ? $this->name : '';
    }
}
