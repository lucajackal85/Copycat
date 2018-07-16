<?php


class SubitoReader implements \Jackal\Copycat\Reader\ReaderInterface
{

    protected $items;
    protected $index;

    public function __construct($content)
    {
        $iterations = 10;
        $originalItems = json_decode($content,true);
        $adItems = $originalItems['ads'];

        for($i=0;$i<$iterations;$i++){
            $adItems = array_merge($adItems,$originalItems['ads']);
        }

        $this->items = [];
        foreach($adItems as $currentAd){
            $this->items[] = [
                'subito_id' => $currentAd['urn'].'-'.uniqid(),
                'created_at' => $currentAd['dates']['display'],
                'saved_at' => (new \DateTime('now')),
                'subject' => $currentAd['subject'],
                'body' => $currentAd['body'],
            ];
        }
    }

    /**
     * Return the current element
     * @link http://php.net/manual/en/iterator.current.php
     * @return mixed Can return any type.
     * @since 5.0.0
     */
    public function current()
    {
        return $this->items[$this->index];
    }

    /**
     * Move forward to next element
     * @link http://php.net/manual/en/iterator.next.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function next()
    {
        $this->index++;
    }

    /**
     * Return the key of the current element
     * @link http://php.net/manual/en/iterator.key.php
     * @return mixed scalar on success, or null on failure.
     * @since 5.0.0
     */
    public function key()
    {
        return $this->index;
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
        return array_key_exists($this->index,$this->items);
    }

    /**
     * Rewind the Iterator to the first element
     * @link http://php.net/manual/en/iterator.rewind.php
     * @return void Any returned value is ignored.
     * @since 5.0.0
     */
    public function rewind()
    {
        $this->index = 0;
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
}