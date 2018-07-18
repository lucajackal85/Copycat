<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 18/07/18
 * Time: 23:03
 */

namespace Jackal\Copycat\Filter\ValueFilter;

class GreaterThanEqualFilter extends LowerThanFilter
{
    public function __invoke($value)
    {
        return !parent::__invoke($value);
    }
}
