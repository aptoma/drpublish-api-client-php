<?php
/**
 * DrPublishApiClientAuthor.php
 * @package    no.aptoma.drpublish.client.web
 */
/**
 * DrPublishApiWebClientAuthor is a customized version of DrPublishApiClientAuthor
 *
 * @package    no.aptoma.drpublish.client.web
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 967 2010-09-27 07:35:54Z stefan $
 * @author     stefan@aptoma.no
 */
class DrPublishApiWebClientAuthor extends DrPublishApiClientAuthor
{

	protected $profileImages = array();
	protected $isOnAboutBox;
	protected $cellPhone;
	protected $jobTitle;
	protected $twitterUsername;

	/**
	 * Class constructor
	 *
	 * @param DOMElement $domElement
	 * @param DOMDocument $dom
	 * @return void
	 */
	public function __construct(DOMElement $domElement, DOMDocument $dom, DrPublishApiClient $dpClient, DOMXPath $xpath)
	{
		parent::__construct($domElement, $dom, $dpClient, $xpath);
		$oab = $this->getProperty('is-on-about-box');
		$this->setIsOnAboutBox(empty($oab)? false : true);
		$this->setCellPhone($this->getProperty('cell-phone'));
		$this->setJobTitle($this->getProperty('job-title'));
		$this->setTwitterUsername($this->getProperty('twitter-username'));
		$profileImages = $dom->getElementsByTagName('profile-image');
		foreach ($profileImages as $profileImage) {
			$this->profileImages[$profileImage->getAttribute('name')] = $profileImage->nodeValue;
		}
	}

	/**
	 * @param boolean $isOnAboutBox
	 * @return void
	 */
	public function setIsOnAboutBox($isOnAboutBox)
	{
		$this->isOnAboutBox = $isOnAboutBox;
	}

	/**
	 * @return boolean
	 */
	public function getIsOnAboutBox()
	{
		return $this->isOnAboutBox;
	}

	/**
	 * @param int $number
	 * @return void
	 */
	public function setCellPhone($number)
	{
		$this->cellPhone = $number;
	}

	/**
	 * @return int
	 */
	public function getCellPhone()
	{
		return $this->cellPhone;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setJobTitle($name)
	{
		$this->jobTitle = $name;
	}

	/**
	 * @return string
	 */
	public function getJobTitle()
	{
		return $this->jobTitle;
	}

	/**
	 * @param string $name
	 * @return void
	 */
	public function setTwitterUsername($name)
	{
		$this->twitterUsername = $name;
	}

	/**
	 * @return string
	 */
	public function getTwitterUsername()
	{
		return $this->twitterUsername;
	}

	/**
	 * @param array $profileImages
	 * @return void
	 */
	public function setProfileImages($profileImages)
	{
		$this->profileImages = $profileImages;
	}

	/**
	 * @return array key=image name
	 */
	public function getProfileImages()
	{
		return $this->profileImages;
	}

}