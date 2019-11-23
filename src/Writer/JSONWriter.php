<?php


namespace Jackal\Copycat\Writer;

/**
 * Class JSONWriter
 * @package Jackal\Copycat\Writer
 */
class JSONWriter extends ArrayWriter
{
    /**
     * JSONWriter constructor.
     * @param $jsonToWrite
     */
    public function __construct(&$jsonToWrite)
    {
        parent::__construct($jsonToWrite);
    }

    /**
     *
     */
    public function finish()
    {
        $this->outItems = json_encode($this->outItems);
    }
}
