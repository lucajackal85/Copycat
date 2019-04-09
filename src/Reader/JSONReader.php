<?php


namespace Jackal\Copycat\Reader;

class JSONReader extends ArrayReader
{
    public function __construct($json)
    {
        $items = json_decode($json, true);

        parent::__construct($items);
    }
}
