<?php

class DrPublishApiClientArticleElement
{

    protected $data;
    protected $medium;
    protected $dpClient;
    protected $dataType;

	public function __construct($data, $options)
	{
        $this->data = $data;
        $this->medium = $options->medium;
        //$this->dpClient = $options->dpClient;
        $this->dataType = $options->dataType;
	}

    function __toString()
    {
        return (string) $this->data;
    }
}
