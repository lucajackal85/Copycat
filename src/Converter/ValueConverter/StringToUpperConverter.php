<?php


namespace Jackal\Copycat\Converter\ValueConverter;


class StringToUpperConverter implements ConverterInterface
{

    public function __invoke($value)
    {
        return mb_strtoupper($value);
    }
}