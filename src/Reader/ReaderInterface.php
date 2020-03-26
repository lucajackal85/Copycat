<?php

namespace Jackal\Copycat\Reader;

use Countable;
use Iterator;

/**
 * Interface ReaderInterface
 * @package Jackal\Copycat\Reader
 */
interface ReaderInterface extends Countable, Iterator
{
    /**
     * @return mixed
     */
    public function first();

    /**
     * @param $index
     * @return mixed
     */
    public function get($index);

    /**
     * @return mixed
     */
    public function all();
}
