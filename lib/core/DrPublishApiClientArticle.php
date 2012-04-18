<?php
/**
 * DrPublishApiClientArticle.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * DrPublishApiClientArticle represents a DrPublish article including its meta information.
 * The class provides several general and specific methods for accessing article elements
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 967 2010-09-27 07:35:54Z stefan $
 * @author     stefan@aptoma.no
 */
class DrPublishApiClientArticle
{

    protected $data = array();
    protected $dpClient;
    protected $medium;
    protected $dom = null;
    protected $xpath = null;

    /**
     * Class constructor
     * @param string $xmlArticle XML representation of an DrPublish article; retrieved from DrPublish API
     * @param DrPublishApiClient Referance to DrPublishApiClient object, used for loading additional information
     * @return void
     * @throws DrPublishApiClientException
     */
    public function __construct($data, DrPublishApiClient $dpClient)
    {
        $this->data = $data;
        $this->dpClient = $dpClient;
        $this->medium = $dpClient->getMedium();

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

    private function parseGetCall($name, $arguments) {
            $varName = lcfirst(substr($name, 3));
            // meta
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
            // article content
                $content = $this->data->contents->{$this->medium};
                if (isset($content->{$varName})) {
                    $templateElement = $this->data->templates->{$this->medium}->elements->{$varName};
                    $options = new stdClass();
                    $options->medium = $this->medium;
                    $options->dataType = $templateElement->dataType;
                    if ($templateElement->dataType == 'text') {
                        return new DrPublishApiClientTextElement($content->{$varName}, $options);
                    } else {
                        return new DrPublishApiClientXmlElement($content->{$varName}, $options);

                    }
                }

            // customizable articletyp meta
            if (isset($this->data->meta->articleTypeMeta->{$varName})) {
                return $this->data->meta->articleTypeMeta->{$varName};
            }
            return "article element '$varName' not found";
    }

    public function findImages()
    {
        return $this->find('img');
    }


    public function find($query) {
        if ($this->dom === null) {
            $this->initDom();
        }
        $domNodeList = $this->xpath->query('descendant::' . $query);
        return DrPublishDomElementList::convertDomNodeList($domNodeList);
    }

    /**
     * Get the image service url - used for image manipulation (resizing by now)
     * @return string | null
     */
    public function getImageServiceUrl()
    {
        return $this->data->service->imageServiceUrl;
    }

    /**
     * Get the image publish url - used for image manipulation (resizing by now)
     * @return string | null
     */
    public function getImagePublishUrl()
    {
        return $this->data->service->imagePublishUrl;
    }

    private function initDom()
    {
        $this->dom = new DOMDocument('1.0', 'UTF-8');
        $xml = '';
        foreach($this->data->templates->{$this->medium}->elements as $templateName => $templateElement) {
            if ($templateElement->dataType == 'xml') {
                $xml .= "<{$templateName}>" . $this->data->contents->{$this->medium}->$templateName . "</{$templateName}>";
            }
        }
        $this->dom->loadXml('<articleContent>'. $xml .'</articleContent>');
        $this->xpath = new DOMXPath($this->dom);
    }


    /**
     * Gets all DPImages included in the article. A DPImage is an picture inserted by using the DrPublish image plugin
     * @see DrPublishApiClientArticleImageElement
     * @return DrPublishApiClientList List items type is DrPublishApiClientArticleImageElement
     */
    public function getDPImages()
    {
        $drPublishDomElementList =  $this->find("div[@class and contains(concat(' ',normalize-space(@class),' '),' dp-article-image ')]");
        $imageList = new DrPublishDomElementList();
        foreach($drPublishDomElementList as $drPublishDomElement) {
            $drPublishApiClientArticleElement = new DrPublishApiClientArticleImageElement($drPublishDomElement);
            $drPublishApiClientArticleElement->setDrPublishApiClientArticle($this);
            $imageList->add($drPublishApiClientArticleElement);
        }
        return $imageList;
    }

    public function getManiCategory()
    {

    }

    /**
     * Gets the first DPImage of this article.
     * @see DrPublishApiClientArticle::getDPImages()
     * @return DrPublishApiClientArticleImageElement | null
     */
    public function getLeadDPImage()
    {
        return $this->getDPImages()->item(0);
    }

    /**
   	 * Gets a list of DrPublishApiWebClientAuthor objects
   	 * @see DrPublishApiClientAuthor
   	 * @return DrPublishApiClientList
   	 */
   	public function getDPAuthors($allData = false)
   	{
   		$list = new DrPublishApiClientList();
   		foreach ($this->data->meta->authors as $author) {
               if ($allData) {
   			      $dpClientAuthor = $this->dpClient->getAuthor($author->id);
               } else {
                   $dpClientAuthor = $this->createDrPublishApiClientAuthor($author);
               }
   			$list->add($dpClientAuthor);
   		}
   		return $list;
   	}

    /**
     * Gets a category list of DrPublishApiClientCategory objects
     * @see DrPublishApiClientCategory
     * @return DrPublishApiClientList
     */
    public function getDPCategories()
    {
        $list = new DrPublishApiClientList();
        foreach ($this->data->meta->categories as $category) {
            $list->add($this->createDrPublishApiClientCategory($category));
        }
        return $list;
    }

    public function getMainDPCategory()
    {

        foreach ($this->data->meta->categories as $category) {
            if ($category->isMain) {
                return $this->createDrPublishApiClientCategory($category);
            }
            return null;
        }

    }

    /**
     * Gets a DrPublishApiClientSource object
     * @return DrPublishApiClientArticleElentList
     */
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

    /**
     * Gets a tag list of DrPublishApiClientTag objects
     * @return DrPublishApiClientArticleElentList
     */
    public function getDPTags()
    {
        $list = new DrPublishApiClientList();
        foreach ($this->data->meta->tags as $tag) {
            $list->add($this->createDrPublishApiClientTag($tag));
        }
        return $list;
    }

    /**
     * Creates a DrPublishApiClientArticleElement from DomElement
     * This method can be overwritten by custom client
     *
     * @param DomElement $domNode
     * @param DomDocument $domDocument
     * @return DrPublishApiClientArticleElement
     */
    protected function createDrPublishApiClientArticleElement($domNode, $domDocument)
    {
        return new DrPublishApiClientArticleElement($domNode, $domDocument, $this->dpClient, $this->xpath);
    }

    /**
     * Creates a DrPublishApiClientArticleImageElement from DomElement
     * This method can be overwritten by custom client
     *
     * @param DomElement $domNode
     * @param DomDocument $domDocument
     * @return DrPublishApiClientArticleImageElement
     */
    protected function createDrPublishApiClientArticleImageElement($domNode, $domDocument)
    {
        return new DrPublishApiClientArticleImageElement($domNode, $domDocument, $this->dpClient, $this->xpath);
    }

    /**
     * Creates a DrPublishApiClientAuthor from DomElement
     * This method can be overwritten by custom client
     *
     * @param DomElement $domNode
     * @param DomDocument $domDocument
     * @return DrPublishApiClientAuthor
     */
    protected function createDrPublishApiClientAuthor($author)
    {
       return new DrPublishApiClientAuthor($author);
    }

    /**
     * Creates a DrPublishApiClientCategory from DomElement
     * This method can be overwritten by custom client
     * @param DomElement $domNode
     * @param DomDocument $domDocument
     * @return DrPublishApiClientCategory
     */
    protected function createDrPublishApiClientCategory($category)
    {
       return new DrPublishApiClientCategory($category, $this->dpClient);
    }

    /**
     * Creates a DrPublishApiClientTag from DomElement
     * This method can be overwritten by custom client
     *
     * @param DomElement $domNode
     * @param DomDocument $domDocument
     * @return DrPublishApiClientCategory
     */
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

    /**
     * Removes elements found by XPATH query
     * @param string $xpathQuery XPATH query
     */
    public function removeElements($xpathQuery)
    {
        $domNodes = $this->xpath->query($xpathQuery, $this->dom);
        foreach ($domNodes as $domNode) {
            $domNode->parentNode->removeChild($domNode);
        }
    }

    /**
     * Changes the node names of elements found by XPATH query
     * @param string $xpathQuery
     * @param string $name new node name
     */
    public function changeNames($xpathQuery, $name)
    {
        $domNodes = $this->xpath->query($xpathQuery, $this->dom);
        foreach ($domNodes as $node) {
            $newNode = $node->ownerDocument->createElement($name);
            foreach ($node->childNodes as $child) {
                $child = $node->ownerDocument->importNode($child, true);
                $newNode->appendChild($child, true);
            }
            foreach ($node->attributes as $attrName => $attrNode) {
                $newNode->setAttribute($attrName, $attrNode);
            }
            $newNode->ownerDocument->replaceChild($newNode, $node);
        }
    }

    public function xml()
    {
        return $this->dom->saveXml();
    }

}
