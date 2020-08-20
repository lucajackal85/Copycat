<?php


namespace Jackal\Copycat\Filter\ValueFilter;


class EqualFilter extends AbstractCompareFilter
{

    protected function getComparison()
    {
        return self::COMPARISON_EQ;
    }
}