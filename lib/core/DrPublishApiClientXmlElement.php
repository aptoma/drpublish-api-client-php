<?
 class DrPublishApiClientXmlElement extends DrPublishApiClientArticleElement
 {
     protected $dom = null;
     protected $xpath = null;

     public function find($query, $asArray = false) {
         if ($this->dom === null) {
             $this->initDom();
         }
         $domNodeList = $this->xpath->query('descendant::' . $query);
         if ($asArray) {
             $out = array();
             foreach($domNodeList as $domElement) {
                 $out[] = $domElement;
             }
             return $out;
         }
         return DrPublishDomElementList::convertDomNodeList($domNodeList);
     }

     public function replace($newContent, $oldElements) {
         $oldElements->replaceBy($newContent);
     }

//     public function remove(DrPublishDomElement) {
//
//     }

     private function initDom()
     {
         $this->dom = new DOMDocument('1.0', 'UTF-8');
         $this->dom->loadXml('<drPublishApiClientXmlElement>'. $this->data .'</drPublishApiClientXmlElement>');
         $this->xpath = new DOMXPath($this->dom);
     }

    function __toString()
    {
       if ($this->dom !== null) {
           return $this->dom->saveXml($this->dom->documentElement);
       }
       return (string) $this->data;
    }

 }
