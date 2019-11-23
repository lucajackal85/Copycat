<?php


namespace Jackal\Copycat\Sorter;

/**
 * Interface SorterInterface
 * @package Jackal\Copycat\Sorter
 */
interface SorterInterface
{
    /**
     * @param $values
     * @return mixed
     */
    public function __invoke(&$values);
}
