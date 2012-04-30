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
        $this->setIsOnAboutBox(empty($oab) ? false : true);
        $this->setCellPhone($this->getProperty('cell-phone'));
        $this->setJobTitle($this->getProperty('job-title'));
        $this->setTwitterUsername($this->getProperty('twitter-username'));
        $profileImages = $this->getProperty('profile-image');
        if (is_array($profileImages)) foreach ($profileImages as $profileImage) {
            $this->profileImages[$profileImage->getAttribute('name')] = $profileImage->nodeValue;
        }
    }

    public function setIsOnAboutBox($isOnAboutBox)
    {
        $this->isOnAboutBox = $isOnAboutBox;
    }

    public function getIsOnAboutBox()
    {
        return $this->isOnAboutBox;
    }

    public function setCellPhone($number)
    {
        $this->cellPhone = $number;
    }

    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    public function setJobTitle($name)
    {
        $this->jobTitle = $name;
    }

    public function getJobTitle()
    {
        return $this->jobTitle;
    }

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

    public function setProfileImages($profileImages)
    {
        $this->profileImages = $profileImages;
    }

    public function getProfileImages()
    {
        return $this->profileImages;
    }

}