<?php


namespace Jackal\Copycat\Filter\ValueFilter;

/**
 * Class NotBlankFilter
 * @package Jackal\Copycat\Filter\ValueFilter
 */
class NotBlankFilter extends AbstractFilter
{
    /**
     * @param $value
     * @return bool
     */
    public function __invoke($value)
    {
        return (isset($value[$this->fieldName]) and strlen($value[$this->fieldName]) > 0) ;
    }
}
