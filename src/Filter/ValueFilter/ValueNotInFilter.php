<?php


namespace Jackal\Copycat\Filter\ValueFilter;

class ValueNotInFilter extends ValueInFilter
{
    public function __invoke($value)
    {
        return !parent::__invoke($value);
    }
}