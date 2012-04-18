<?php

class DrPublishDomText  {

    public $domText;
    public $ownerDocument;


    public function __construct(DomText $domText) {
        $this->domText = $domText;
        $this->ownerDocument = $domText->ownerDocument;

    }

    public function __toString() {
        return $this->domText->wholeText;
    }

    public function textValue()
    {
        return $this->__toString();
    }
}