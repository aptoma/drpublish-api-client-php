<?php

class DrPublishApiClientArticleImageElement extends DrPublishDomElement
{
    protected $dpClientImage = null;
    private $renditions = array();

    private $digitalAssetPictures = false;
    private $options = array();
    private $assetSource = null;

    public function __construct(DrPublishDomElement $drPublishDomElement, $renditions = array(), $options = array(), $assetSource = null)
    {
        $this->renditions = $renditions;
        $this->options = $options;
        $this->assetSource = $assetSource;
        parent::__construct($drPublishDomElement->domElement);
        if ($this->find("*.dp-picture")) {
            $this->digitalAssetPictures = true;
        }
    }

    public function getTitle()
    {
        return $this->find("*.dp-article-image-title")->innerContent();
    }

    public function getDescription()
    {
        return $this->find("*.dp-article-image-description")->innerContent();
    }

    public function getSource()
    {
        return $this->find("*.dp-article-image-source")->innerContent();
    }

    public function getLabel()
    {
        return $this->find("*.dp-article-image-byline-label")->innerContent();
    }

    public function getPhotographer()
    {
        return $this->find("*.dp-article-image-author")->innerContent();
    }

    public function getSrc()
    {
        return $this->getImage() ? $this->getImage()->getSrc() : null;
    }

    public function getUrl()
    {
        return $this->getSrc();
    }

    public function getWidth()
    {
        return $this->getImage() ? $this->getImage()->getWidth() : null;
    }

    public function getHeight()
    {
        return $this->getImage() ? $this->getImage()->getHeight() : null;
    }

    /**
     * Resize the image
     *
     * @param string $type the image format/ratio/type to resize to
     * @return DrPublishApiClientImage
     */
    public function getResizedImage($type)
    {
        $image = $this->getImage();
        if (empty($image)) {
            return null;
        }
        if ($this->digitalAssetPictures) {
            if (isset($this->renditions->{$type})) {
                $image->setSrc($this->renditions->{$type}->uri);
                if (isset($this->renditions->{$type}->width)) {
                    $image->setAttribute('width', $this->renditions->{$type}->width);
                } else {
                    $image->setAttribute('width', '');
                }
                if (isset($this->renditions->{$type}->height)) {
                    $image->setAttribute('height', $this->renditions->{$type}->height);
                } else {
                    $image->setAttribute('height', '');
                }
            } else {
                $size = explode('x', $type);
                $width = $size[0];
                if (isset($size[1])) {
                    $height = $size[1];
                } else {
                    $height = $width;
                }
                if ($this->assetSource == 'imbo') {
                    $image->imboResize($width, $height);
                }
            }
        } else {
            $image->resize($type);
        }
        return $image;
    }

    public function getSquareCropResizedImage($width)
    {
        $image = $this->getImage();
        if (empty($image)) {
            return null;
        }
        $squareCropParamString = $this->getAttribute('data-square-crop');
        if (!empty($squareCropParamString)) {
            $squareCropParams = mb_split(',', $squareCropParamString);
            $squareCropParams[4] = $width;
            $type = 'crop-' . join(',', $squareCropParams);
        } else {
            $type = 'autocrop-' . $width . 'x' . $width;
        }
        return $image->resize($type);
    }

    public function getThumbnail($size = 100)
    {
        return $this->getResizedImage($size);
    }

    public function getImage()
    {
        if ($this->dpClientImage === null) {
            $domItem = $this->domElement->getElementsByTagName('img')->item(0);
            if($domItem && is_object($domItem)) {
                $imageElement = clone $domItem;
                if (!empty($imageElement)) {
                    $this->dpClientImage = new DrPublishApiClientImage($imageElement);
                }
            }
        }
        return $this->dpClientImage;
    }


    public function getDPPhotographer()
    {
        $photographer = new DrPublishApiClientPhotographer();
        $photographer->setId($this->getAttribute('data-author-id'));
        $photographer->setName(urldecode($this->getAttribute('data-author-name')));
        $photographer->setUsername($this->getAttribute('data-author-username'));
        $photographer->setEmail($this->getAttribute('data-author-email'));
        return $photographer;
    }
}
