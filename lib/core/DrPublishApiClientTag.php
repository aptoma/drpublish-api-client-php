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
	private $id;
	private $name;
	private $data;
	private $tagTypeId;
	private $tagTypeName;

	/**
	 * @param int $id
	 * @return void
	 */
	public function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setTagTypeName($tagTypeName)
	{
		$this->tagTypeName = $tagTypeName;
	}

	/**
	 * @return string
	 */
	public function getTagTypeName()
	{
		return $this->tagTypeName;
	}

	/**
	 * @param string $id
	 * @return void
	 */
	public function setTagTypeId($tagTypeId)
	{
		$this->tagTypeId = $tagTypeId;
	}

	/**
	 * @return string
	 */
	public function getTagTypeId()
	{
		return $this->tagTypeId;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setData($data)
	{
		$this->data = $data;
	}

	/**
	 * @return string
	 */
	public function getData()
	{
		return $this->data;
	}
}
