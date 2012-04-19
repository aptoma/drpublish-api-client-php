<?php
/**
 * DrPublishApiClientSearchList.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * DrPublishApiClientSearchList is an extension of DrPublishApiClientList with additional metadata for search results
 *
 * Available parameters are:
 * - string $query The query for the search
 * - int $offset The offset given for the search
 * - int $limit The limit given for the search
 * - int $hits The number of returned hits
 * - int $total The total number of hits
 * - float $time The time the search took in seconds
 *
 * __get, __set, __isset and __unset are overloaded so that access can be done through attributes
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @author     jon@aptoma.no
 *
 * @see DrPublishApiClientList
 */
class DrPublishApiClientSearchList extends DrPublishApiClientList {

    protected $search;

    public function __construct($search, $headers)
    {
        //$searchMeta->headers = $response->headers;
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
        if (isset($this->data->{$name}))
        {
            $this->data->{$name};
        }
        return 'undefined';
    }

    public function __call($name, $arguments) {
        if (substr($name, 0, 3) === 'get') {
            $varName = lcfirst(substr($name, 3));
            if (isset($this->data->{$varName})) {
                return $this->data->{$varName};
            }
            return 'undefined';
        }
    }

    public function setProperty($name, $value) {
        $this->data->{$name} = $value;
    }


}