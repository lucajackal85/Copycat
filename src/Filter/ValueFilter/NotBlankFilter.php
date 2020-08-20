<?php

namespace Jackal\Copycat\Filter\ValueFilter;

/**
 * Class NotBlankFilter
 * @package Jackal\Copycat\Filter\ValueFilter
 */
class NotBlankFilter extends EqualFilter{
    public function __construct($fieldName)
    {
        parent::__construct($fieldName, '');
    }

    public function __invoke($value)
    {
        return !parent::__invoke($value);
    }


}
