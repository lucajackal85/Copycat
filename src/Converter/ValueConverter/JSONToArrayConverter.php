<?php


namespace Jackal\Copycat\Converter\ValueConverter;


class JSONToArrayConverter extends AbstractConverter
{

    public function __invoke($value)
    {
        $value[$this->fieldName] = json_decode($value[$this->fieldName],true);

        return $value;
    }
}