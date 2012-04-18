<?php
/**
 * DrPublishApiWebClient.php
 * @package    no.aptoma.drpublish.client.web
 */
/**
 * DrPublishApiWebClientArticle is a customized version of DrPublishApiClientArticle
 *
 * @package    no.aptoma.drpublish.client.web
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 970 2010-09-27 11:10:59Z stefan $
 * @author     stefan@aptoma.no
 *
 * @see DrPublishApiClientArticle
 */
class DrPublishApiWebClientArticle extends DrPublishApiClientArticle
{
    public function getBodyText()
    {
        return $this->getStory();
    }

//
//	/**
//	 * Creates a DrPublishApiWebClientImageElement from DomElement
//	 *
//	 * @param DomElement $domNode
//	 * @param DomDocument $domDocument
//	 * @return DrPublishApiWebClientArticleImageElement
//	 */
//	protected function createDrPublishApiClientArticleImageElement($domNode, $domDocument)
//	{
//		return new DrPublishApiWebClientImageElement($domNode, $domDocument, $this->dpClient, $this->xpath);
//	}
//
//	/**
//	 * Creates a DrPublishApiWebClientArticleElement from DomElement
//	 *
//	 * @param DomElement $domNode
//	 * @param DomDocument $domDocument
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	protected function createDrPublishApiClientArticleElement($domNode, $domDocument)
//	{
//		return new DrPublishApiWebClientArticleElement($domNode, $domDocument, $this->dpClient, $this->xpath);
//	}
//
//	/**
//	 * Sets the output medium, the publication channel e.g. "web", "ipad", "mobile".
//	 *
//	 * @param string $medium edium must be defined in DPTemplate/DPContent
//	 */
//	public function setMedium($medium)
//	{
//		$this->medium = $medium;
//	}

	/**
	 * Gets the publication channel e.g. "web", "ipad", "mobile"
	 *
	 * @return string
	 */
//	public function getMedium()
//	{
//		return $this->medium;
//	}
//
//	public function getPublication()
//	{
//	  return $this->getElement('//DrPublish:meta/publication[1]');
//	}
//
//
//	/**
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	public function getId()
//	{
//		return $this->getElement('//DrPublish:meta/id[1]');
//	}
//
//	/**
//	 * Simple source name element
//	 *
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	public function getSourceName()
//	{
//		return $this->getElement('//DrPublish:meta/source[1]');
//	}
//
//	/**
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	public function getPublished()
//	{
//		return $this->getElement('//DrPublish:meta/published[1]');
//	}
//
//	/**
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	public function getModified()
//	{
//		return $this->getElement('//DrPublish:meta/modified[1]');
//	}
//
//	/**
//	 * Simple list of tag elements
//	 *
//	 * @return DrPublishApiClientList element type in list is DrPublishApiWebClientArticleElement
//	 */
//	public function getTagNames()
//	{
//		return $this->getElements('//DrPublish:meta/tags/tag');
//	}
//
//	/**
//	 * Simple list of category elements
//	 *
//	 * @return DrPublishApiClientList element type in list is DrPublishApiWebClientArticleElement
//	 */
//	public function getCategories()
//	{
//		return $this->getElements('//DrPublish:meta/categories/category');
//	}
//
//	/**
//	 * Simple list of author elements
//	 *
//	 * @return DrPublishApiClientList element type in list is DrPublishApiWebClientArticleElement
//	 */
//	public function getAuthorNames()
//	{
//		return $this->getElements('//DrPublish:meta/authors/author');
//	}
//
//	/**
//	 * Simple category element with attribute "isMain"=1
//	 *
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	public function getMainCategoryName()
//	{
//		return $this->getElement('DrPublish:article/DrPublish:meta/categories/category[@isMain="1"]');
//	}
//
//	/**
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	public function getTitle()
//	{
//		//print_r($this->dom->saveXml());
//        return   $this->getElement('DrPublish:article/DrPublish:contents/DrPublish:content[@medium="' . $this->medium . '"]/title[1]');
//	}
//
//	/**
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	public function getPreamble()
//	{
//		return $this->getElement('DrPublish:article/DrPublish:contents/DrPublish:content[@medium="' . $this->medium . '"]/preamble[1] | DrPublish:article/DrPublish:contents/DrPublish:content[@medium="' . $this->medium . '"]/excerpt[1]');
//	}
//
//	/**
//	 * NB: Returns only the <div> element from leadAsset editor content
//	 *
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	public function getLeadAsset()
//	{
//		return $this->getElement('//DrPublish:article/DrPublish:contents/DrPublish:content[@medium="' . $this->medium . '"]/leadAsset/descendant::object[1]|descendant::embed[1]|descendant::div[1]');
//	}
//
//	/**
//	 * Returns all images in only the given field as DrPublishApiWebClientImageElements
//	 *
//	 * @return DrPublishApiWebClientImageElement
//	 */
//	public function getImagesFrom ( $field )
//	{
//	  $list = new DrPublishApiClientList();
//	  $xp = "//DrPublish:article/DrPublish:contents/DrPublish:content[@medium='" . $this->medium . "']/$field//div[@class and contains(concat(' ',normalize-space(@class),' '),' dp-article-image ')]";
//	  $domNodes = $this->xpath->query($xp);
//	  foreach ($domNodes as $domNode) {
//	    $list->add($this->createDrPublishApiClientArticleImageElement($domNode, $this->dom));
//	  }
//	  return $list;
//	}
//
//	/**
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	public function getBodyText()
//	{
//		return $this->getElement('//DrPublish:article/DrPublish:contents/DrPublish:content[@medium="' . $this->medium . '"]/story | //DrPublish:article/DrPublish:contents/DrPublish:content[@medium="' . $this->medium . '"]/body');
//	}
//
//	/**
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	public function getBody()
//	{
//		return $this->getBodyText();
//    }
//
//	/**
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	public function getImages()
//	{
//		return $this->getElements('//img');
//	}
//
//	/**
//	 * Gets a list of DrPublishApiClientArticleImages objects whitch provide extended functionality as
//	 * - getting and manipulating (resizing) the image element
//	 * - getting the photographer as object
//	 *
//	 * @see DrPublishApiClientArticleImageElement
//	 * @return DrPublishApiWebClientArticleElement
//	 */
//	public function getDPImages()
//	{
//		return parent::getDPImages();
//	}
//
//	/**
//	 * Simple list of fact box elements
//	 *
//	 * @return DrPublishApiClientList element type in list is DrPublishApiWebClientArticleElement
//	 */
//	public function getFactBoxes()
//	{
//		return $this->getElements("//DrPublish:article/DrPublish:contents/DrPublish:content/descendant::div[@class and contains(concat(' ',normalize-space(@class),' '),' dp-fact-box ')]");
//	}

}
