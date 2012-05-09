<?
class DrPublishApiClientXmlElement extends DrPublishApiClientArticleElement
{
    protected $dom = null;
    protected $xpath = null;

    public function find($query, $asArray = false)
    {
        if ($this->dom === null) {
            $this->initDom();
        }
        $query = DrPublishDomElement::parseQuery($query);
        $domNodeList = $this->xpath->query($query);
        if ($asArray) {
            $out = array();
            foreach ($domNodeList as $domElement) {
                $out[] = $domElement;
            }
            return $out;
        }
        return DrPublishDomElementList::convertDomNodeList($domNodeList);
    }

    public function replace($newContent, $oldElements)
    {
        $oldElements->replaceBy($newContent);
    }

    private function initDom()
    {
        $this->dom = new DOMDocument('1.0', 'UTF-8');
        $this->dom->loadXml('<drPublishApiClientXmlElement>' . $this->data . '</drPublishApiClientXmlElement>');
        $this->xpath = new DOMXPath($this->dom);
    }

    function __toString()
    {
       return $this->content();
    }

    public function content()
    {
        if ($this->dom !== null) {
            return $this->dom->saveXml($this->dom->documentElement);
        }
        return (string)$this->data;
    }

    public function html()
    {
        if ($this->dom === null) {
            $this->initDom();
        }
        $xml = $this->dom->saveXml($this->dom->documentElement, LIBXML_NOEMPTYTAG);
        return preg_replace('!></(meta|link|base|basefont|param|img|br|hr|area|input)>!', ' />', $xml);
    }

    public function innerContent()
    {
        return preg_replace(array('#^<[^>]*>#','#</[^>]*>$#'), '', $this->content());
    }

    public function innerHtml()
    {
       $xhtml = $this->html();
       return preg_replace(array('#^<[^>]*>#','#</[^>]*>$#'), '', $xhtml);
    }

    public function getDPImages()
    {
        $drPublishDomElementList =  $this->find("div.dp-article-image");
        $imageList = new DrPublishDomElementList();
        foreach($drPublishDomElementList as $drPublishDomElement) {
            $drPublishApiClientArticleElement = new DrPublishApiClientArticleImageElement($drPublishDomElement);
            $imageList->add($drPublishApiClientArticleElement);
        }
        return $imageList;
    }

    public function getDPSlideShows()
    {
        $drPublishDomElementList =  $this->find("div.dp-slideshow");
        $slideShowList = new DrPublishDomElementList();
        require_once(dirname(__FILE__) . '/../content/DrPublishApiClientArticleSlideShowElement.php');
        foreach($drPublishDomElementList as $drPublishDomElement) {
            $drPublishApiClientArticleElement = new DrPublishApiClientArticleSlideShowElement($drPublishDomElement);
            $slideShowList->add($drPublishApiClientArticleElement);
        }
        return $slideShowList;
    }

}
