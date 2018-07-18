<?php


namespace Jackal\Copycat\Converter\ValueConverter;

class ObjectToStringConverter implements ConverterInterface
{
    public function __invoke($value)
    {
        return serialize($value);
    }
}
