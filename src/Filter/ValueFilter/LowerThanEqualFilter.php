<?php

namespace Jackal\Copycat\Filter\ValueFilter;

/**
 * Class LowerThanEqualFilter
 * @package Jackal\Copycat\Filter\ValueFilter
 */
class LowerThanEqualFilter extends AbstractCompareFilter{

    protected function getComparison()
    {
        return self::COMPARISON_LTE;
    }
}
