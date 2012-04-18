<?php
class DrPublishDomElementList implements Iterator {
    private $position = 0;
    private $elements = array();



    public function add($element) {
        $this->elements[] = $element;
    }

    public function __construct() {
        $this->position = 0;
    }

    public function rewind() {
        $this->position = 0;
    }

    public function current() {
        return $this->elements[$this->position];
    }

    public function item($pos) {
        if(isset($this->elements[$pos])) {
            return $this->elements[$pos];
        }
        return null;
    }

    public function key() {
        return $this->position;
    }

    public function next() {
        ++$this->position;
    }

    public function valid() {
        return isset($this->elements[$this->position]);
    }

    public function __toString() {
        $string = '';
        foreach($this->elements as $domElement) {
            $string .= (string) $domElement;
        }
        return $string;
    }

    public function getAttributes($name) {
        $attributes = array();
        foreach ($this->elements as $domElement) {
            $attribute = $domElement->getAttribute($name);
            $attributes[] =  $attribute;
        }
        return $attributes;
    }

    public static function convertDomNodeList(DOMNodeList $domNodeList)
    {
        $drPublishDomElementList = new DrPublishDomElementList();
        foreach($domNodeList as $domElement) {
            if ($domElement instanceof DOMElement) {
                $drPublishDomElementList->add(new DrPublishDomElement($domElement));
            } else if ($domElement instanceof DOMText) {
                $drPublishDomElementList->add(new DrPublishDomText($domElement));

            }
        }
        return $drPublishDomElementList;
    }

}