<?php


namespace Jackal\Copycat\Converter;

use Jackal\Copycat\Converter\ValueConverter\ConverterInterface;

class ConversionMap
{
    protected $map = [];

    /**
     * @param $field
     * @param callable|ConverterInterface $converter
     */
    public function add(callable $converter)
    {
        $this->map[] = $converter;
    }

    public function apply(array &$values)
    {
        if (!count($this->map)) {
            return $values;
        }

        foreach ($this->map as $converter) {
            $values = $converter($values);
        }
    }
}
