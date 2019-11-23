<?php


namespace Jackal\Copycat\Reader;

class ArrayReader extends BaseReader
{
    public function __construct(array $items = [])
    {
        $this->setItems($items);
    }
}
