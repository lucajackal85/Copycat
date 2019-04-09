<?php


namespace Jackal\Copycat\Converter\ValueConverter;

class StringToDateTimeConverter extends AbstractConverter
{
    public function __invoke($value)
    {
        $value[$this->fieldName] = new \DateTime($value[$this->fieldName]);

        return $value;
    }
}
