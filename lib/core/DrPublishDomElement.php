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

    public function replaceBy($newContent) {
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

        }  else {
            throw new DrPublishApiClientException('You tried to replace content on a non-existing element');
        }
    }

    public function remove()
    {
        if (is_object($this->domElement->parentNode)) {
           $this->domElement->parentNode->removeChild($this->domElement);
        }  else {
            throw new DrPublishApiClientException('Youw tried to remove a non-existing element');
        }
    }
}