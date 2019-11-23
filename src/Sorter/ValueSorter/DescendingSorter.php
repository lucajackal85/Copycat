<?php


namespace Jackal\Copycat\Sorter\ValueSorter;

/**
 * Class DescendingSorter
 * @package Jackal\Copycat\Sorter\ValueSorter
 */
class DescendingSorter extends AscendingSorter
{
    /**
     * @return int
     */
    protected function getOrder()
    {
        return SORT_DESC;
    }
}
