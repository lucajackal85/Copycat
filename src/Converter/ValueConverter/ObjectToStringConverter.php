<?php

namespace Jackal\Copycat\Converter\ValueConverter;

/**
 * Class ObjectToStringConverter
 * @package Jackal\Copycat\Converter\ValueConverter
 */
class ObjectToStringConverter extends AbstractConverter
{
    /**
     * @param $value
     * @return mixed
     */
    public function __invoke($value)
    {
        $value[$this->fieldName] = serialize($value[$this->fieldName]);

        return $value;
    }
}
