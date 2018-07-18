<?php


namespace Jackal\Copycat\Filter;

class FilterMap
{
    /**
     * @var array
     */
    protected $map = [];

    public function add(callable $filter)
    {
        $this->map[] = $filter;
    }

    public function apply(array &$values)
    {
        foreach ($this->map as $filter) {
            if ($filter($values) == false) {
                return false;
            }
        }

        return true;
    }
}
