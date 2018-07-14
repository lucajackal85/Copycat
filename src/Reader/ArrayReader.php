<?php


namespace Jackal\Copycat\Reader;


class ArrayReader extends IteratorReader
{
    public function __construct(array $items)
    {
        $this->items = $items;
    }
}