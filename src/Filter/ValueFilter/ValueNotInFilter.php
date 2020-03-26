<?php

namespace Jackal\Copycat\Filter\ValueFilter;

/**
 * Class ValueNotInFilter
 * @package Jackal\Copycat\Filter\ValueFilter
 */
class ValueNotInFilter extends ValueInFilter
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
