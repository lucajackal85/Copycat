<?php


namespace Jackal\Importer\Reader;


class ArrayReader extends IteratorReader
{
    public function __construct(array $items)
    {
        $this->items = $items;
    }
}