<?php

class DrPublishApiClientImage extends DrPublishDomElement
{
    /**
     * @return int
     */
    public function getWidth()
    {
        return (int)$this->getAttribute('width');
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return (int)$this->getAttribute('height');
    }

    /**
     * Alias for DrPublishApiClientImage::getSrc()
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->getSrc();
    }

    /**
     * Gets the souce attribute
     *
     * @return string
     */
    public function getSrc()
    {
        return $this->getAttribute('src');
    }

    public function resize($type)
    {
        $currentSrc = $this->getAttribute('src');
        try {
            $properties = DrPublishApiClient::resizeImage($currentSrc, $type, DrPublishApiClientArticle::getImageServiceUrl(),  DrPublishApiClientArticle::getImagePublishUrl());
        } catch (DrPublishApiClientException $e) {
            throw $e;
        }
        $this->setAttribute('src', $properties['src']);
        if (array_key_exists('width', $properties)) {
            $this->setAttribute('width', $properties['width']);
        }
        if (array_key_exists('height', $properties)) {
            $this->setAttribute('height', $properties['height']);
        }
        return $this;
    }

}
