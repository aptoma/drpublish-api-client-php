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
}