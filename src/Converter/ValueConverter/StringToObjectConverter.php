<?php


namespace Jackal\Copycat\Converter\ValueConverter;


class StringToObjectConverter implements ConverterInterface
{

    public function __invoke($value)
    {
        return unserialize($value);
    }
}