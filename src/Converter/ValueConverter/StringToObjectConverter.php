<?php


namespace Jackal\Copycat\Converter\ValueConverter;

class StringToObjectConverter extends AbstractConverter
{
    public function __invoke($value)
    {
        $value[$this->fieldName] = unserialize($value[$this->fieldName]);

        return $value;
    }
}
