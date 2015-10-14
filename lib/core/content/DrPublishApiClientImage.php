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

    /**
     * Sets the souce attribute
     *
     * @param string
     */
    public function setSrc($src)
    {
        return $this->setAttribute('src', $src);
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

    public function imboResize($width, $height)
    {
        $src = $this->getAttribute('src');
        $parts = parse_url($src);
        parse_str(urldecode($parts['query']), $arr);

        foreach ($arr['t'] as $key => $transformation) {
            if (strpos(strtolower($transformation), 'maxsize') !== false) {
                print '<p>(maxSize) unsetting '.$transformation.'</p>';
                $arr['t'][$key] = '';
            }
        }
        $arr['t'] = array_filter($arr['t']);
        $arr['t'][] = 'maxSize:width='.$width.',height='.$height;

        $query = http_build_query($arr);
        $parts['query'] = $query;

        $url = $parts['scheme'].'://'.$parts['host'].$parts['path'].'?';
        $url .= $parts['query'];
        $this->setAttribute('src', $url);

        if ($this->getAttribute('width')) {
            $this->setAttribute('width', $width);
        }
        if ($this->getAttribute('height')) {
            $this->setAttribute('height', $height);
        }
        return $this;
    }
}
