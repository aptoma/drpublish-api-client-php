<?php
/**
 * DrPublishApiClientTag.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * DrPublishApiClientAuthor represents an article tag (keyword)
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 967 2010-09-27 07:35:54Z stefan $
 * @author     stefan@aptoma.no
 */
class DrPublishApiClientTag extends DrPublishApiClientArticleElement
{
	protected $id;
	protected $name;
	protected $data;
	protected $tagTypeId;
	protected $tagTypeName;

    public function __construct($data) {
        foreach($data as $key => $value) {
            $this->{$key} = $value;
        }
        $this->tagTypeId = $data->tagType->id;
        $this->tagTypeName = $data->tagType->name;
    }


	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}


	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}



	/**
	 * @return string
	 */
	public function getTagTypeName()
	{
		return $this->tagTypeName;
	}



	/**
	 * @return string
	 */
	public function getTagTypeId()
	{
		return $this->tagTypeId;
	}



	/**
	 * @return string
	 */
	public function getData()
	{
		return $this->data;
	}
    /**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}
}
