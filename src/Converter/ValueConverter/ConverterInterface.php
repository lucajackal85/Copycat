<?php


namespace Jackal\Copycat\Converter\ValueConverter;

interface ConverterInterface
{
    public function __invoke($value);
}
