<?php


namespace Jackal\Copycat\Converter\ValueConverter;


class JSONToArrayConverter implements ConverterInterface
{

    public function __invoke($value)
    {
        return json_decode($value,true);
    }
}