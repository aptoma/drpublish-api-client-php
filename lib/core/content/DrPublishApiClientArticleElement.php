<?php

class DrPublishApiClientArticleElement
{

    protected $data;
    protected $medium;
    protected $dataType;

	public function __construct($data, $options)
	{
        $this->data = $data;
        $this->medium = $options->medium;
        $this->dataType = $options->dataType;
	}

    function __toString()
    {
        return (string) $this->data;
    }


}
