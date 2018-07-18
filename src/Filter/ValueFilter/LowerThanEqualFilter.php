<?php
/**
 * Created by PhpStorm.
 * User: luca
 * Date: 18/07/18
 * Time: 23:07
 */

namespace Jackal\Copycat\Filter\ValueFilter;

class LowerThanEqualFilter extends GreaterThanFilter
{
    public function __invoke($value)
    {
        return !parent::__invoke($value);
    }
}
