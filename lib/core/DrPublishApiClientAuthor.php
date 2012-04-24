<?php

class DrPublishApiClientAuthor
{

    protected $fullName;
    protected $userName;

    public function __construct($data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
        $this->fullName = $data->fullname;
        $this->userName = $data->username;
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
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        return $this->userName;
    }


    /**
     * @return string
     */
    public function getEmail()
    {
        return isset($this->email) ? $this->email : '';
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