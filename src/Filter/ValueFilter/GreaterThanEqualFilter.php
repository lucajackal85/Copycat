<?php

namespace Jackal\Copycat\Filter\ValueFilter;

class GreaterThanEqualFilter extends LowerThanFilter
{
    public function __invoke($value)
    {
        return !parent::__invoke($value);
    }
}
