<?php

namespace Jackal\Copycat\Filter\ValueFilter;

/**
 * Class GreaterThanEqualFilter
 * @package Jackal\Copycat\Filter\ValueFilter
 */
class GreaterThanEqualFilter extends LowerThanFilter
{
    /**
     * @param $value
     * @return bool
     */
    public function __invoke($value)
    {
        return !parent::__invoke($value);
    }
}
