<?php

class DrPublishApiWebClientArticle extends DrPublishApiClientArticle
{

    /**
     * Returns the article body content field (stored in the story element)
     *
     * @return DrPublishApiClientXmlElement
     */
    public function getBodyText()
    {
        return $this->getStory();
    }

	/**
	 * Simple category element with attribute "isMain"=1
	 *
	 * @return DrPublishApiClientArticleElement
	 */
	public function getMainCategoryName()
	{
		return $this->getMainDPCategory();
	}

	/**
	 * Simple list of fact box elements
	 *
	 * @return DrPublishApiClientList
	 */
    public function getFactBoxes()
    {
        return $this->find('div.dp-fact-box');
    }

}
