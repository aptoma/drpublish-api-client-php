<?php

class DrPublishApiClientAuthor extends DrPublishApiClientArticleEntity
{

    protected $fullName;
    protected $userName;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->fullName = $data->fullname;
        $this->userName = $data->username;
    }


    /**
     * Magic method to convert the autor to string (using its full name)
     */
    public function __toString()
    {
        return $this->getFullName();
    }

    public function getProperty($name)
    {
        if (!empty($this->{$name})) {
            return $this->{$name};
        } else {
            return '';
        }
    }

}