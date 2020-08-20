<?php

namespace Jackal\Copycat\Filter\ValueFilter;

/**
 * Class GreaterThanEqualFilter
 * @package Jackal\Copycat\Filter\ValueFilter
 */
class GreaterThanEqualFilter extends AbstractCompareFilter{

    protected function getComparison()
    {
        return self::COMPARISON_GTE;
    }
}
