<?php


namespace Jackal\Copycat\Converter\ValueConverter;


class ArrayToJSONConverter extends AbstractConverter
{

    public function __invoke($value)
    {
        $value[$this->fieldName] = json_encode($value[$this->fieldName]);

        return $value;
    }
}