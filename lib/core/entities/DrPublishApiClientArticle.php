<?php
class DrPublishApiClientArticle
{
    protected $data = array();
    protected $dpClient;
    protected $medium;
    protected $articleContentXmlElements = null;
    protected static $imageServiceUrl;
    protected static $imagePublishUrl;

    public static $defaultImageServiceUrl = '';
    public static $defaultImagePublishUrl = '';

    public function __construct($data, DrPublishApiClient $dpClient)
    {
        $this->data = $data;
        $this->dpClient = $dpClient;
        $this->setMedium($dpClient->getMedium());
        $this->buildArticleXmlContentElements();

        self::$imagePublishUrl = self::$defaultImagePublishUrl;
        self::$imageServiceUrl = self::$defaultImageServiceUrl;

        if (!empty($this->data->service)) {
            self::$imagePublishUrl = isset($this->data->service->imagePublishUrl) ? $this->data->service->imagePublishUrl : self::$defaultImagePublishUrl;
            self::$imageServiceUrl = isset($this->data->service->imageServiceUrl) ? $this->data->service->imageServiceUrl : self::$defaultImageServiceUrl;
        }
    }

    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {
        if (isset($this->data->{$name})) {
            return $this->data->{$name};
        }
    }

    public function __call($name, $arguments) {
        if (substr($name, 0, 3) === 'get') {
            return $this->parseGetCall($name, $arguments);
        }
    }

    public function setMedium($medium)
    {
        $this->medium = $medium;
    }

    public function getMedium()
    {
        return $this->medium;
    }

    private function parseGetCall($name, $arguments) {
        $varName = lcfirst(substr($name, 3));
        if (isset($this->data->meta->{$varName})) {
            switch ($varName) {
            case 'authors' :
                return $this->getDPAuthors($arguments);
            case 'tags' :
                return $this->getDPTags($arguments);
            case 'categories' :
                return $this->getDPCategories($arguments);
            case 'source' :
                return $this->getDPSource($arguments);
            default:
                return $this->data->meta->{$varName};
            }
        }
        if (isset($this->data->contents) && isset($this->data->contents->{$this->medium})) {
            $content = $this->data->contents->{$this->medium};
            if ($content !== null && isset($content->{$varName})) {
                if (isset($this->data->templates->{$this->medium}->elements->{$varName})) {
                    $templateElement = $this->data->templates->{$this->medium}->elements->{$varName};
                    if (isset($this->articleContentXmlElements[$varName])) {
                        return $this->articleContentXmlElements[$varName];
                    }
                    $options = new stdClass();
                    $options->medium = $this->medium;
                    $options->dataType = isset($templateElement->dataType) ? $templateElement->dataType : '';
                    if ($templateElement->dataType == 'xml') {
                        return new DrPublishApiClientXmlElement($content->{$varName}, $options);
                    } else {
                        return new DrPublishApiClientTextElement($content->{$varName}, $options);
                    }
                }
            }
        }
        if (isset($this->data->meta->articleTypeMeta->{$varName})) {
            return $this->data->meta->articleTypeMeta->{$varName};
        }
        return null;
    }

    public function find($query) {
        if ($this->articleContentXmlElements === null) {
            $this->buildArticleXmlContentElements();
        }
        $drPublishDomElementList = new DrPublishDomElementList();
        if (!empty($this->articleContentXmlElements))foreach ($this->articleContentXmlElements as $drPublishApiClientXmlElement) {
            if ($drPublishApiClientXmlElement instanceof DrPublishApiClientXmlElement) {
                $drPublishDomElements = $drPublishApiClientXmlElement->find($query);
                foreach($drPublishDomElements as $drPublishDomElement) {
                    $drPublishDomElementList->add($drPublishDomElement);
                }
            }
        }
        return $drPublishDomElementList;
    }

    public static function getImageServiceUrl()
    {
        return self::$imageServiceUrl;
    }

    public static function getImagePublishUrl()
    {
        return self::$imagePublishUrl;
    }

    private function buildArticleXmlContentElements()
    {
        $this->articleContentXmlElements = array();
        if (!empty($this->data->templates->{$this->medium}->elements)) {
            foreach($this->data->templates->{$this->medium}->elements as $templateName => $templateElement) {
                $this->articleContentXmlElements[$templateName] =  $this->{'get'. ucfirst($templateName)}();
            }
        }
    }

    public function getDPSlideShows()
    {
        $drPublishDomElementList =  $this->find("div.dp-slideshow");
        $slideShowList = new DrPublishDomElementList();
        foreach($drPublishDomElementList as $drPublishDomElement) {
            $drPublishApiClientArticleElement = $this->createDrPublishApiClientArticleSlideShowElement($drPublishDomElement);
            $slideShowList->add($drPublishApiClientArticleElement);
        }
        return $slideShowList;
    }

    public function getDPImages()
    {
        $q = 'div[@class and contains(concat(" ",normalize-space(@class)," ")," dp-article-image ") and descendant::img]';
        DrPublishDomElement::$queryMode = QUERY_TYPE_XPATH;
        $drPublishDomElementList =  $this->find($q);
        DrPublishDomElement::$queryMode = QUERY_TYPE_JQUERY;
        $imageList = new DrPublishDomElementList();
        foreach($drPublishDomElementList as $drPublishDomElement) {
            $drPublishApiClientArticleElement = $this->createDrPublishApiClientArticleImageElement($drPublishDomElement);
            $imageList->add($drPublishApiClientArticleElement);
        }
        $q = 'div[@class and contains(concat(" ",normalize-space(@class)," ")," dp-picture ") and descendant::img]';
        DrPublishDomElement::$queryMode = QUERY_TYPE_XPATH;
        $drPublishDomElementList =  $this->find($q);
        DrPublishDomElement::$queryMode = QUERY_TYPE_JQUERY;
        foreach($drPublishDomElementList as $drPublishDomElement) {
            $drPublishApiClientArticleElement = $this->createDrPublishApiClientArticleImageElement($drPublishDomElement);
            $imageList->add($drPublishApiClientArticleElement);
        }
        return $imageList;
    }

    public function getLeadDPImage()
    {
        return $this->getDPImages()->item(0);
    }

    public function getDPAuthors($allData = false)
    {
        $list = new DrPublishApiClientList();
        if (!empty($this->data->meta->authors)) foreach ($this->data->meta->authors as $author) {
            if ($allData) {
                try {
                    $dpClientAuthor = $this->dpClient->getAuthor($author->id);
                } catch (DrPublishApiClientException $e) {
                    if ($e->getCode() == DrPublishApiClientException::NO_DATA_ERROR) {
                        trigger_error('DrPublishApiClient error: no data responded for author id= "' . $author->id . '"' , E_USER_WARNING);
                        $dpClientAuthor = null;
                    } else {
                        throw new DrPublishApiClientException($e);
                    }
                }
            } else {
                $dpClientAuthor = $this->createDrPublishApiClientAuthor($author);
            }
            if ($dpClientAuthor !== null) {
                $list->add($dpClientAuthor);
            }
        }
        return $list;
    }

    public function getDPCategories()
    {
        $list = new DrPublishApiClientList();
        if (!empty($this->data->meta->categories)) foreach ($this->data->meta->categories as $category) {
            $list->add($this->createDrPublishApiClientCategory($category));
        }
        return $list;
    }

    public function getMainDPCategory()
    {
        if (!empty($this->data->meta->categories)) foreach ($this->data->meta->categories as $category) {
            if (isset($category->isMain) && $category->isMain) {
                return $this->createDrPublishApiClientCategory($category);
            }
        }
        return null;
    }

    public function getDPSource()
    {
        if (empty($this->data->meta->source)) {
            return null;
        }
        $data = new stdClass();
        $data->name = isset($this->data->meta->source) ? $this->data->meta->source : '';
        $data->id = isset($this->data->meta->dpSourceId) ? $this->data->meta->dpSourceId : 0;
        return new DrPublishApiClientSource($data);
    }

    public function getDPTags()
    {
        $list = new DrPublishApiClientList();
        foreach ($this->data->meta->tags as $tag) {
            $list->add($this->createDrPublishApiClientTag($tag));
        }
        return $list;
    }

    public function getMainDPTag()
    {
        if (!empty($this->data->meta->tags)) {
            foreach ($this->data->meta->tags as $tag) {
                if (is_object($tag) && isset($tag->position) && $tag->position === 1) {
                    return $this->createDrPublishApiClientTag($tag);
                }
            }
            $firstTag = current($this->data->meta->tags);
            if (is_object($firstTag)) {
                return $this->createDrPublishApiClientTag($firstTag);
            }
        }
        return null;
    }

    protected function createDrPublishApiClientArticleImageElement(DrPublishDomElement $image)
    {
        $imageAsset = null;
        if (!empty($this->data->assets)) {
            $internalId = $image->getAttribute('data-internal-id');
            if ($internalId) {
                foreach ($this->data->assets as $asset) {
                    if ($asset->internalId == $internalId) {
                        $imageAsset = $asset;
                    }
                }
            }
        }
        if ($imageAsset) {
            return new DrPublishApiClientArticleImageElement($image, $imageAsset->renditions, $imageAsset->options, $imageAsset->assetSource);
        } else {
            return new DrPublishApiClientArticleImageElement($image);
        }
    }

    protected function createDrPublishApiClientArticleSlideShowElement(DrPublishDomElement $slideShow)
    {
        return new DrPublishApiClientArticleSlideShowElement($slideShow);
    }

    protected function createDrPublishApiClientAuthor($author)
    {
        return new DrPublishApiClientAuthor($author);
    }

    protected function createDrPublishApiClientCategory($category)
    {
        return new DrPublishApiClientCategory($category, $this->dpClient);
    }

    protected function createDrPublishApiClientTag($tag)
    {
        $data = new stdClass();
        $tagType = new stdClass();
        $tagType->id = isset($tag->tagTypeId) ? $tag->tagTypeId : 0;
        $tagType->name = isset($tag->tagTypeName) ? $tag->tagTypeName : '';
        $data->id =  isset($tag->id)? $tag->id : 0;
        $data->name = isset($tag->name)? $tag->name : '';
        $data->tagType =  $tagType;
        return new DrPublishApiClientTag($data);
    }

    public function __toString()
    {
        if ($this->articleContentXmlElements === null) {
            return '';
        }
        $out = '';
        foreach ($this->articleContentXmlElements as $fieldName => $drPublishApiClientArticleElement) {
            $out .= "<div class=\"dr-publish-article-field $fieldName\">";
            $out .= (string) $drPublishApiClientArticleElement;
            $out .= "</div  >";
        }
        return $out;
    }

}
