<?php


namespace Jackal\Copycat\Converter\ValueConverter;


class ArrayToJSONConverter implements ConverterInterface
{

    public function __invoke($value)
    {
        return json_encode($value);
    }
}