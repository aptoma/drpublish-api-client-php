<?php

class DrPublishDomElement
{
    public $domElement;
    public $ownerDocument;
    public $tagName;
    public $xpath = null;
    public static $queryMode = QUERY_TYPE_JQUERY;

    public function __construct(DomElement $domElement)
    {
        $this->domElement = $domElement;
        $this->ownerDocument = $domElement->ownerDocument;
        $this->tagName = $domElement->tagName;
    }

    public static function setQueryMode($mode)
    {
        self::$queryMode = $mode;
    }

    public function __toString()
    {
        return $this->content();
    }

    public function find($query)
    {
        $query = self::parseQuery($query);
        if ($this->xpath == null) {
            $this->xpath = new DOMXPath($this->ownerDocument);
        }
        $domNodeList = $this->xpath->query($query, $this->domElement);
        return DrPublishDomElementList::convertDomNodeList($domNodeList);
    }

    public function getAttribute($name)
    {
        return $this->domElement->getAttribute($name);
    }

    public function setAttribute($name, $value)
    {
        return $this->domElement->setAttribute($name, $value);
    }

    public function textValue()
    {
        return strip_tags($this->__toString());
    }

    public function replaceBy($newContent)
    {
        if ($newContent instanceof DrPublishDomElement) {
            $domElement = $newContent->domElement;
        } else if ($newContent instanceof DomElement) {
            $domElement = $newContent;
        } else if (is_string($newContent)) {
            $domElement = $this->ownerDocument->createDocumentFragment();
            $domElement->appendXML($newContent);
        }
        if ($domElement->ownerDocument != $this->ownerDocument) {
            $this->ownerDocument->importNode($domElement, true);
        }
        if (is_object($this->domElement->parentNode)) {
            $this->domElement->parentNode->replaceChild($domElement, $this->domElement);
            $this->domElement = $domElement;

        } else {
            throw new DrPublishApiClientException('You tried to replace content on a non-existing element');
        }
    }

    public function remove()
    {
        if (is_object($this->domElement->parentNode)) {
            $this->domElement->parentNode->removeChild($this->domElement);
        } else {
            throw new DrPublishApiClientException('You tried to remove a non-existing element');
        }
    }

    public static function parseQuery($query)
    {
        if (self::$queryMode === QUERY_TYPE_XPATH) {
            return 'descendant::' . $query;
        }
        $query = preg_replace('#\[(\w)#', '[@$1', $query);
        $orParts = explode(',', $query);
        $xpathQuery = '';
        foreach ($orParts as $key => $orPart) {
            $parsed = '';
            $matches = array();
            preg_match_all('#[^\s]+#', trim($orPart), $matches);
            if (!empty($matches[0])) foreach ($matches[0] as $match) {
                // element with a given class
                if (strpos($match, '.', 1) !== false) {
                    $parts = explode('.', $match);
                    $parsed .= '/descendant::' . $parts[0] . '[@class and contains(concat(" ",normalize-space(@class)," ")," ' . $parts[1] . ' ")]';
                    // all elements with a given class
                } elseif ($match[0] == '.') {
                    $parsed .= '/descendant::*[@class and contains(concat(" ",normalize-space(@class)," ")," ' . substr($match, 1) . ' ")]';
                    // any type of element with a property like that
                } else if ($match[0] == '[') {
                    $parsed .= '/descendant::*' . $match;
                }
                // any type of element with a given id
                else if ($match[0] == '#') {
                    $parsed .= '/descendant::*[@id="' . substr($match, 1) . '"][1]';
                    // element with given tag name
                } else {
                    $parsed .= '/descendant::' . $match;
                }
            }
            if ($parsed[0] == '/') {
                $parsed = substr($parsed, 1);
            }
            if ($key > 0) {
                $xpathQuery .= ' | ';
            }
            $xpathQuery .= $parsed;
        }
        return $xpathQuery;
    }

    public function content()
    {
        return $this->ownerDocument->saveXML($this->domElement);
    }

    /**
     * Returns the content of the root element
     * @return string
     * @deprecated
     */
    public function innerContent()
    {
       return preg_replace(array('#^<[^>]*>#','#</[^>]*>$#'), '', $this->content());
    }
}