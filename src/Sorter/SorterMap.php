<?php


namespace Jackal\Copycat\Sorter;

/**
 * Class SorterMap
 * @package Jackal\Copycat\Sorter
 */
class SorterMap
{
    /**
     * @var array
     */
    protected $map = [];

    /**
     * @param callable $sorter
     */
    public function add(callable $sorter)
    {
        $this->map[] = $sorter;
    }

    /**
     * @return bool
     */
    public function hasSorter()
    {
        return count($this->map) > 0;
    }

    /**
     * @param array $values
     */
    public function apply(array &$values)
    {
        foreach ($this->map as $sorter) {
            $sorter($values);
        }
    }
}
