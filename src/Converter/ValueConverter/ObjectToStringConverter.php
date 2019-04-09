<?php


namespace Jackal\Copycat\Converter\ValueConverter;

class ObjectToStringConverter extends AbstractConverter
{
    public function __invoke($value)
    {
        $value[$this->fieldName] = serialize($value[$this->fieldName]);

        return $value;
    }
}
