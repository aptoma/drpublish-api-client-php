<?php
/**
 * DrPublishApiClientList.php
 * @package    no.aptoma.drpublish.client.core
 */
/**
 * DrPublishApiClientList is a simple collection of various elements witch can be iterated using foreach
 *
 * @package    no.aptoma.drpublish.client.core
 * @copyright  Copyright (c) 2006-2010 Aptoma AS (http://www.aptoma.no)
 * @version    $Id: DrPublishApiClient.php 967 2010-09-27 07:35:54Z stefan $
 * @author     stefan@aptoma.no
 *
 * @see Iterator
 */
class DrPublishApiClientList implements Iterator
{

	protected $items = array();
	protected $position = 0;

	/**
	 * Adds an item to the list
	 * @param mixed $item
	 * @return void
	 */
	public function add($item)
	{
		$this->items[] = $item;
	}

	/**
	 * Resets the pointer to the start position
	 *
	 * @return void
	 */
	public function rewind()
	{
		$this->position = 0;
	}

	/**
	 * Returns whether nor not the position pointer points to an existing item
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return ($this->position < count($this->items) && $this->position >= 0);
	}

	/**
	 * Returns the pointer position
	 *
	 * @return int
	 */
	public function key()
	{
		return $this->position;
	}
	
	/**
	 * Returns the number of elements in the list
	 *
	 * @return int
	 */
	public function size() {
	  return count ( $this -> items );
	}
	
	/**
	 * Returns true if there are more elements in the list, false otherwise
	 *
	 * @return bool
	 */
	public function hasNext() {
	  return $this -> position < $this -> size() - 1;
	}

	/**
	 * Gets the element the pointer currently points to
	 *
	 * @return mixed | null
	 */
	public function current()
	{
		return $this->items[$this->position];
	}

	/**
	 * Gets item by key (position)
	 * @param $key
	 * @return mixed | null
	 */
	public function item($key)
	{
		if (isset($this->items[$key])) {
			return $this->items[$key];
		} else {
			return null;
		}
	}

	public function next()
	{
		$this->position++;
		if ($this->valid()) {
			return $this->current();
		} else {
			return null;
		}
	}

	/**
	 * Rurns the previous item in the list
	 * @return mixed | null
	 */
	public function previous()
	{
		$this->position--;
		if ($this->valid()) {
			return $this->current();
		} else {
			return null;
		}
	}

	/**
	 * Returns the first item in the list
	 * @return mixed | null
	 */
	public function first()
	{
		if (isset($this->items[0])) {
			return $this->items[0];
		} else {
			return null;
		}
	}

	/**
	 * Get an array with attributes "$name" of all collected DrPublishApiClientArticleElements
	 * @param string $name Attribute name
	 * @return array string[]
	 */
	public function getAttributes($name)
	{
		$attributes = array();
		foreach ($this as $element) {
			$attributes[] = $element->getAttribute($name);
		}
		return $attributes;
	}

	/**
	 * Magic method for converting all collected DrPublishApiClientArticleElements to a comma separated string
	 * @return string
	 */
	public function __toString()
	{
		$contents = array();
		foreach ($this->items as $item)
		{
			$contents[] = (string) $item;
		}
		return join(', ' , $contents);
	}

}