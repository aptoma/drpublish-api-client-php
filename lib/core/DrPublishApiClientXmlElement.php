<?
 class DrPublishApiClientXmlElement extends DrPublishApiClientArticleElement
 {
     protected $dom = false;
     protected $xpath = false;

     public function query($xpathQuery) {
         if ($this->dom === false) {
             $this->initDom();
         }
         return $this->xpath->query($xpathQuery);
     }

     private function initDom()
     {
         $this->dom = new DOMDocument('1.0', 'UTF-8');
         $this->dom->loadXml('<drPublishApiClientXmlElement>'. $this->data .'</drPublishApiClientXmlElement>');
         $this->xpath = new DOMXPath($this->dom);
     }


 }

class DrPublishDomElement extends DomElement {
    public function __toString() {
        
    }
}