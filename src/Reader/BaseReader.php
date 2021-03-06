<?php

namespace Jackal\Copycat\Reader;

/**
 * Class BaseReader
 * @package Jackal\Copycat\Reader
 */
abstract class BaseReader implements ReaderInterface
{
    /**
     * @var int
     */
    private $cursor = 0;

    /**
     * @var array
     */
    private $items = [];

    /**
     * @param array $item
     */
    protected function addItem(array $item)
    {
        $this->items[] = $item;
    }

    /**
     * @param array $items
     */
    protected function setItems(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param $index
     * @return array
     */
    public function get($index)
    {
        if (!isset($this->items[$index])) {
            return null;
        }

        return $this->items[$index];
    }

    public function all()
    {
        return $this->items;
    }

    /**
     * @return array
     */
    public function first()
    {
        if (!isset($this->items[0])) {
            return null;
        }

        return $this->items[0];
    }

    /**
     * Count elements of an object
     * @link http://php.net/manual/en/countable.count.php
     * @return int The custom count as an integer.
     * </p>
     * <p>
     * The return value is cast to an integer.
     * @since 5.1.0
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->items[$this->cursor];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->cursor++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->cursor;
    }

    /**
     * Checks if current position is valid
     * @link http://php.net/manual/en/iterator.valid.php
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     * @since 5.0.0
     */
    public function valid()
    {
        return array_key_exists($this->cursor, $this->items);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->cursor = 0;
    }
}
