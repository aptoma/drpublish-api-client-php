<?php

class DrPublishApiClientList implements Iterator
{

    protected $items = array();
    protected $position = 0;

    public function add($item)
    {
        $this->items[] = $item;
    }

    public function rewind()
    {
        $this->position = 0;
    }

    public function valid()
    {
        return ($this->position < count($this->items) && $this->position >= 0);
    }

    public function key()
    {
        return $this->position;
    }

    public function size()
    {
        return count($this->items);
    }

    public function hasNext()
    {
        return $this->position < $this->size() - 1;
    }

    public function current()
    {
        return $this->items[$this->position];
    }

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

    public function previous()
    {
        $this->position--;
        if ($this->valid()) {
            return $this->current();
        } else {
            return null;
        }
    }

    public function first()
    {
        if (isset($this->items[0])) {
            return $this->items[0];
        } else {
            return null;
        }
    }

    public function getAttributes($name)
    {
        $attributes = array();
        foreach ($this as $element) {
            $attributes[] = $element->getAttribute($name);
        }
        return $attributes;
    }

    public function __toString()
    {
        $contents = array();
        foreach ($this->items as $item) {
            $contents[] = (string)$item;
        }
        return join(', ', $contents);
    }

}