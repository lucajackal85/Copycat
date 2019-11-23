<?php


namespace Jackal\Copycat\Converter\ValueConverter;

/**
 * Class ArrayToJSONConverter
 * @package Jackal\Copycat\Converter\ValueConverter
 */
class ArrayToJSONConverter extends AbstractConverter
{
    /**
     * @param $value
     * @return mixed
     */
    public function __invoke($value)
    {
        $value[$this->fieldName] = json_encode($value[$this->fieldName]);

        return $value;
    }
}
