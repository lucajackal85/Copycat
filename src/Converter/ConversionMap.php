<?php

namespace Jackal\Copycat\Converter;

use Jackal\Copycat\Converter\ValueConverter\ConverterInterface;

/**
 * Class ConversionMap
 * @package Jackal\Copycat\Converter
 */
class ConversionMap
{
    protected $map = [];

    /**
     * @param callable|ConverterInterface $converter
     */
    public function add(callable $converter)
    {
        $this->map[] = $converter;
    }

    /**
     * @param array $values
     */
    public function apply(array &$values)
    {
        foreach ($this->map as $converter) {
            $values = $converter($values);
        }
    }
}
