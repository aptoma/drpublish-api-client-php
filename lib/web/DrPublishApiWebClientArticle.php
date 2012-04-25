<?php

class DrPublishApiWebClientArticle extends DrPublishApiClientArticle
{
    public function getBodyText()
    {
        return $this->getStory();
    }


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


//	public function getSourceName()
//	{
//		return $this->getElement('//DrPublish:meta/source[1]');
//	}
//

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
//	 * Simple list of author elements
//	 *
//	 * @return DrPublishApiClientList element type in list is DrPublishApiWebClientArticleElement
//	 */
//	public function getAuthorNames()
//	{
//		return $this->getElements('//DrPublish:meta/authors/author');
//	}
//
	/**
	 * Simple category element with attribute "isMain"=1
	 *
	 * @return DrPublishApiWebClientArticleElement
	 */
	public function getMainCategoryName()
	{
		return $this->getMainDPCategory();
	}



//	/**
//	 * Simple list of fact box elements
//	 *
//	 * @return DrPublishApiClientList element type in list is DrPublishApiWebClientArticleElement
//	 */
    public function getFactBoxes()
    {
        return $this->find('div.dp-fact-box');
        //return $this->getElements("//DrPublish:article/DrPublish:contents/DrPublish:content/descendant::div[@class and contains(concat(' ',normalize-space(@class),' '),' dp-fact-box ')]");
    }

}
