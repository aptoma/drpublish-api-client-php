<?php

class DrPublishApiClientSearchList extends DrPublishApiClientList
{

    protected $search;

    public function __construct($search, $headers)
    {
        if ($search === null) {
            $search = new stdClass();
        }
        $search->status = $headers['status'];
        $search->links = new stdClass();
        if (isset($headers['Link'])) {
            $split = explode(',', $headers['Link']);
            foreach ($split as $link) {
                $m = array();
                preg_match('#<(.*)>; rel=\"(\w+)\"#', $link, $m);
                if (isset($m[1]) && isset($m[2])) {
                    $link = $m[1];
                    $lsplit = explode('?', $link);
                    $linkObject = new stdClass();
                    $linkObject->uri = $link;
                    $linkObject->base = $lsplit[0];
                    $linkObject->parameters = $lsplit[1];
                    $search->links->{$m[2]} = $linkObject;
                }
            }
        }
        $this->search = new DrPublishApiClientSearch($search);
    }

    public function getSearchProperty($name)
    {
        return $this->search->getProperty($name);
    }

    public function setSearchProperty($name, $value)
    {
        return $this->search->setProperty($name, $value);
    }

    public function getSearch()
    {
        return $this->search;
    }

    public function hasLink($label)
    {
        return isset($this->search->getLinks('links')->{$label});
    }

    public function getLink($label)
    {
        if ($this->hasLink($label)) {
            return $this->search->getLinks('links')->{$label};
        }
        return null;
    }

}

class DrPublishApiClientSearch
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function getProperty($name)
    {
        if (isset($this->data->{$name})) {
            $this->data->{$name};
        }
        return null;
    }

    public function __call($name, $arguments)
    {
        if (substr($name, 0, 3) === 'get') {
            $varName = lcfirst(substr($name, 3));
            if (isset($this->data->{$varName})) {
                return $this->data->{$varName};
            }
            return null;
        }
    }

    public function setProperty($name, $value)
    {
        $this->data->{$name} = $value;
    }


}