<?php


namespace Jackal\Copycat\Reader;

interface ReaderInterface extends \Countable, \Iterator
{
    public function all();
}
