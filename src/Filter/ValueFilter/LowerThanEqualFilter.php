<?php

namespace Jackal\Copycat\Filter\ValueFilter;

class LowerThanEqualFilter extends GreaterThanFilter
{
    public function __invoke($value)
    {
        return !parent::__invoke($value);
    }
}
