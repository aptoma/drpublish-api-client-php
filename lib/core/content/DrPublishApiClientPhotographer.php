<?php

class DrPublishApiClientPhotographer
{
	private $id;
	private $name;
	private $username;
	private $email;

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
	public function setUsername($name)
	{
		$this->username = $name;
	}

	/**
	 * @return string
	 */
	public function getUsername()
	{
		return $this->username;
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
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
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
	 * Magic method to convert this class to string using the photographer name
	 * @return unknown_type
	 */
	public function __toString()
	{
		return $this->getName();
	}
}