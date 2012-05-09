<?php

class DrPublishApiClientArticleSlideShowElement extends DrPublishDomElement
{
    protected $dpImages;

    public function __construct(DrPublishDomElement $drPublishDomElement)
    {
        $drPublishDomElementList =  $drPublishDomElement->find("div.dp-article-image");
        $imageList = new DrPublishDomElementList();
        foreach($drPublishDomElementList as $drPublishDomElement) {
            $drPublishApiClientArticleElement = new DrPublishApiClientArticleImageElement($drPublishDomElement);
            $imageList->add($drPublishApiClientArticleElement);
        }
        $this->dpImages = $imageList;
    }

    public function getDPImages()
    {
        return $this->dpImages;
    }
}
