<?php


namespace Jackal\Copycat\Converter\ValueConverter;

class StringToUpperConverter extends AbstractConverter
{
    public function __invoke($value)
    {
        $value[$this->fieldName] = mb_strtoupper($value[$this->fieldName]);

        return $value;
    }
}
