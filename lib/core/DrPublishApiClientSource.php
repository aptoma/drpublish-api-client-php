<?php

class DrPublishApiClientSource extends DrPublishApiClientArticleElement
{
	protected $id;
	protected $name;

    public function __construct($data) {
        foreach($data as $key => $value) {
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

    public function __toString()
    {
        return $this->name;
    }

}