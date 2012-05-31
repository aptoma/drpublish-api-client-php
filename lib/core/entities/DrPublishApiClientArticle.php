<?php
class DrPublishApiClientArticle
{

    protected $data = array();
    protected $dpClient;
    protected $medium;
    protected $articleContentXmlElements = null;
    protected static $imageServiceUrl;
    protected static $imagePublishUrl;

    public function __construct($data, DrPublishApiClient $dpClient)
    {
        $this->data = $data;
        $this->dpClient = $dpClient;
        $this->setMedium($dpClient->getMedium());
        $this->buildArticleXmlContentElements();
        self::$imagePublishUrl =  $this->data->service->imagePublishUrl;
        self::$imageServiceUrl =  $this->data->service->imageServiceUrl;

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
                        $options->dataType = $templateElement->dataType;
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
        require_once(dirname(__FILE__) . '/../content/DrPublishApiClientArticleSlideShowElement.php');
        foreach($drPublishDomElementList as $drPublishDomElement) {
            $drPublishApiClientArticleElement = $this->createDrPublishApiClientArticleSlideShowElement($drPublishDomElement);
            $slideShowList->add($drPublishApiClientArticleElement);
        }
        return $slideShowList;
    }

    public function getDPImages()
    {
        $drPublishDomElementList =  $this->find("div.dp-article-image");
        $imageList = new DrPublishDomElementList();
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
                           throw($e);
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

    public function getDPDossiers()
    {
        $list = new DrPublishApiClientList();
        if (!empty($this->data->meta->dossiers)) foreach ($this->data->meta->dossiers as $dossier) {
            $list->add($this->createDrPublishApiClientDossier($dossier));
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
            if ($category->isMain) {
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
        $data->name = $this->data->meta->source;
        $data->id = $this->data->meta->dpSourceId;
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

    protected function createDrPublishApiClientArticleImageElement(DrPublishDomElement $image)
    {
       return new DrPublishApiClientArticleImageElement($image);
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

    protected function createDrPublishApiClientDossier($dossier)
    {
       return new DrPublishApiClientDossier($dossier);
    }

    protected function createDrPublishApiClientTag($tag)
    {
       $data = new stdClass();
       $tagType = new stdClass();
       $tagType->id = $tag->tagTypeId;
       $tagType->name = $tag->tagTypeName;
       $data->id = $tag->id;
       $data->name = $tag->name;
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
