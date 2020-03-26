<?php

namespace Jackal\Copycat\Reader;

/**
 * Class JSONReader
 * @package Jackal\Copycat\Reader
 */
class JSONReader extends ArrayReader
{
    /**
     * JSONReader constructor.
     * @param $json
     */
    public function __construct($json)
    {
        $items = json_decode($json, true);

        parent::__construct($items);
    }
}
