<?php

class DrPublishApiWebClientImageElement extends DrPublishApiClientArticleImageElement
{

    public function getThumbnail($size = 100)
    {
        return $this->getResizedImage($size);
    }

    /**
     * Gets the image title
     * @return string
     */
    public function getTitle()
    {
        $dpArticleElement = $this->getElement('[class="dp-article-image-title"]');
        return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
    }

    /**
     * Gets the image description
     * @return string
     */
    public function getDescription()
    {
        $dpArticleElement = $this->getElement('[class="dp-article-image-description"]');
        return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
    }

    /**
     * Gets the image byline label
     * @return string
     */
    public function getBylineLabel()
    {
        $dpArticleElement = $this->getElement('[class="dp-article-byline-label"]');
        return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
    }

    /**
     * Gets the image source
     * @return string
     */
    public function getAuthor()
    {
        $dpArticleElement = $this->getElement('[class="dp-article-image-author"]');
        return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
    }

    /**
     * Gets the image source
     * @return string
     */
    public function getSource()
    {
        $dpArticleElement = $this->getElement('[class="dp-article-image-source"]');
        return $dpArticleElement === null ? '' : $dpArticleElement->__toString();
    }

}