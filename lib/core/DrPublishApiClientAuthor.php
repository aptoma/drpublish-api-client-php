<?php
/**
 * DrPublishApiClientAuthor.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * DrPublishApiClientAuthor represents an article author
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 967 2010-09-27 07:35:54Z stefan $
 * @author     stefan@aptoma.no
 */
class DrPublishApiClientAuthor extends DrPublishApiClientArticleElement
{
	protected $id;
	protected $fullName;
	protected $userName;
	protected $email;

	/**
	 * Class constructor
	 *
	 * @param DOMElement $domElement
	 * @param DOMDocument $dom
	 * @param DrPublishApiClient $dpClient
	 * @return void
	 */
	public function __construct(DOMElement $domElement, DOMDocument $dom, DrPublishApiClient $dpClient, DOMXPath $xpath)
	{
		parent::__construct($domElement, $dom, $dpClient, $xpath);
		$this->setId($this->getProperty('id'));
		$this->setFullName($this->getProperty('fullname'));
		$this->setUserName($this->getProperty('username'));
		$this->setEmail($this->getProperty('email'));
	}

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
	public function setFullName($name)
	{
		$this->fullName = $name;
	}

	/**
	 * @return string
	 */
	public function getFullName()
	{
		return $this->fullName;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setUserName($name)
	{
		$this->userName = $name;
	}

	/**
	 * @return string
	 */
	public function getUserName()
	{
		return $this->userName;
	}

	/**
	 * @param string $email
	 * @return void
	 */
	public function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Magic method to convert the autor to string (using its full name)
	 */
	public function __toString()
	{
		return $this->getFullName();
	}

	public function getProperty($name)
	{
		$node = $this->dom->getElementsByTagName($name)->item(0);
		if (!empty($node)) {
			return $node->nodeValue;
		} else {
			return '';
		}
	}

}