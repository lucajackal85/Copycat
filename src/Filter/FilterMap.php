<?php

namespace Jackal\Copycat\Filter;

/**
 * Class FilterMap
 * @package Jackal\Copycat\Filter
 */
class FilterMap
{
    /**
     * @var array
     */
    protected $map = [];

    /**
     * @param callable $filter
     */
    public function add(callable $filter)
    {
        $this->map[] = $filter;
    }

    /**
     * @param array $values
     * @return bool
     */
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
