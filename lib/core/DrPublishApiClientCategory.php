<?php
/**
 * DrPublishApiClientCategory.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * DrPublishApiClientAuthor represents an article category
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 967 2010-09-27 07:35:54Z stefan $
 * @author     stefan@aptoma.no
 */
class DrPublishApiClientCategory extends DrPublishApiClientArticleElement
{

	private $id;
	private $name;
	private $parentId;
	private $isMain;
	private $parent;

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
	 * Sets parent category id
	 *
	 * @param int $parentId
	 * @return void
	 */
	public function setParentId($parentId)
	{
		$this->parentId = $parentId;
	}

	/**
	 * Gets parent category id
	 *
	 * @return int
	 */
	public function getParentId()
	{
		return $this->parentId;
	}

	/**
	 * Gets the parent (if any)
	 * @return DrPublishApiClientCategory
	 */
	public function getParent()
	{
		return $this->dpClient->getCategory($this->parentId);
	}

	/**
	 * If true, this category is the main one
	 *
	 * @param boolean $isMain
	 * @return void
	 */
	public function setIsMain($isMain)
	{
		$this->isMain = ((int) $isMain === 1);
	}

	/**
	 * If "true" is returned, this category is the main one
	 * @return boolean
	 */
	public function getIsMain()
	{
		return $this->isMain;
	}
	

	/**
	 * Magic method to convert the category to string (using its name)
	 */
	public function __toString()
	{
		return $this->getName();
	}
	

}