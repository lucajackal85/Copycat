<?php


namespace Jackal\Copycat\Sorter;

class SorterMap
{
    /**
     * @var array
     */
    protected $map = [];

    public function add(callable $sorter)
    {
        $this->map[] = $sorter;
    }

    public function hasSorter()
    {
        return count($this->map) > 0;
    }

    public function apply(array &$values)
    {
        foreach ($this->map as $sorter) {
            $sorter($values);
        }
    }
}
