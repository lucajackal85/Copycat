<?php

namespace Jackal\Copycat\Filter\ValueFilter;

/**
 * Class LowerThanEqualFilter
 * @package Jackal\Copycat\Filter\ValueFilter
 */
class LowerThanEqualFilter extends GreaterThanFilter
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
