<?php

namespace Jackal\Copycat\Filter\ValueFilter;

use DateTime;

/**
 * Class GreaterThanFilter
 * @package Jackal\Copycat\Filter\ValueFilter
 */
class GreaterThanFilter extends AbstractCompareFilter{

    protected function getComparison()
    {
        return self::COMPARISON_GT;
    }
}
