<?php
class DrPublishApiWebClientAuthor extends DrPublishApiClientAuthor
{

	protected $profileImages = array();
	protected $isOnAboutBox;
	protected $cellPhone;
	protected $jobTitle;
	protected $twitterUsername;

	public function __construct($data)
	{
		parent::__construct($data);
		$oab = $this->getProperty('is-on-about-box');
		$this->setIsOnAboutBox(empty($oab)? false : true);
		$this->setCellPhone($this->getProperty('cell-phone'));
		$this->setJobTitle($this->getProperty('job-title'));
		$this->setTwitterUsername($this->getProperty('twitter-username'));
		$profileImages = $this->getProperty('profile-image');
		if (is_array($profileImages)) foreach ($profileImages as $profileImage) {
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