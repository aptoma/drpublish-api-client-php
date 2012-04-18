<?php

class DrPublishDomElement  {

    public $domElement;
    public $ownerDocument;
    public $tagName;
    public $xpath = null;


    public function __construct(DomElement $domElement) {
        $this->domElement = $domElement;
        $this->ownerDocument = $domElement->ownerDocument;
        $this->tagName = $domElement->tagName;
    }

    public function __toString() {
        return $this->ownerDocument->saveXML($this->domElement);
    }

    public function find($query) {
        if ($this->xpath == null) {
            $this->xpath = new DOMXPath($this->ownerDocument);
        }
        $domNodeList = $this->xpath->query('descendant::' . $query, $this->domElement);
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
}