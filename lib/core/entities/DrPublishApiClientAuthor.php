<?php
class DrPublishApiClientAuthor extends DrPublishApiClientArticleEntity
{

    protected $fullName;
    protected $fullname;
    protected $userName;
    protected $username;
    protected $email;
    protected $id;

    public function __construct($data)
    {
        parent::__construct($data);
        $this->fullName = $data->fullname;
        $this->userName = $data->username;
    }

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