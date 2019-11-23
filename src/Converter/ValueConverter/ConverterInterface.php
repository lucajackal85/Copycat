<?php


namespace Jackal\Copycat\Converter\ValueConverter;

/**
 * Interface ConverterInterface
 * @package Jackal\Copycat\Converter\ValueConverter
 */
interface ConverterInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function __invoke($value);
}
