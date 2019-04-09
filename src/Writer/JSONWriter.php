<?php


namespace Jackal\Copycat\Writer;

class JSONWriter extends ArrayWriter
{
    public function __construct(&$jsonToWrite)
    {
        parent::__construct($jsonToWrite);
    }

    public function finish()
    {
        $this->outItems = json_encode($this->outItems);
    }
}
