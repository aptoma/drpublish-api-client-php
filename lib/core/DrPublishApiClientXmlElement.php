<?
 class DrPublishApiClientXmlElement extends DrPublishApiClientArticleElement
 {
     protected $dom = null;
     protected $xpath = null;

     public function find($query) {
         if ($this->dom === null) {
             $this->initDom();
         }
         $domNodeList = $this->xpath->query('descendant::' . $query);
         return DrPublishDomElementList::convertDomNodeList($domNodeList);
     }

     private function initDom()
     {
         $this->dom = new DOMDocument('1.0', 'UTF-8');
         $this->dom->loadXml('<drPublishApiClientXmlElement>'. $this->data .'</drPublishApiClientXmlElement>');
         $this->xpath = new DOMXPath($this->dom);
     }

 }
