<?php

class DrPublishApiWebClientArticle extends DrPublishApiClientArticle
{

    public function getBodyText()
    {
        return $this->getStory();
    }

    public function getMainCategoryName()
    {
        return $this->getMainDPCategory();
    }

    public function getFactBoxes()
    {
        return $this->find('div.dp-fact-box');
    }

}
