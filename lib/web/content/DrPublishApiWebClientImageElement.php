<?php

class DrPublishApiWebClientImageElement extends DrPublishApiClientArticleImageElement
{

    public function getThumbnail($size = 100)
    {
        return $this->getResizedImage($size);
    }

    public function getTitle()
    {
        $dpArticleElement = $this->getElement('[class="dp-article-image-title"]');
        return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
    }

    public function getDescription()
    {
        $dpArticleElement = $this->getElement('[class="dp-article-image-description"]');
        return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
    }

    public function getBylineLabel()
    {
        $dpArticleElement = $this->getElement('[class="dp-article-byline-label"]');
        return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
    }

    public function getAuthor()
    {
        $dpArticleElement = $this->getElement('[class="dp-article-image-author"]');
        return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
    }

    public function getSource()
    {
        $dpArticleElement = $this->getElement('[class="dp-article-image-source"]');
        return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
    }
}