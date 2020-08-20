<?php

namespace Jackal\Copycat\Filter\ValueFilter;

use DateTime;

/**
 * Class LowerThanFilter
 * @package Jackal\Copycat\Filter\ValueFilter
 */
class LowerThanFilter extends AbstractCompareFilter
{

    protected function getComparison()
    {
        return self::COMPARISON_LT;
    }
}
