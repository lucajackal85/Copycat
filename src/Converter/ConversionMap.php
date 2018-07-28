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
    public function add($field, callable $converter)
    {
        $this->map[$field] = $converter;
    }

    public function apply(array &$values)
    {
        if (!count($this->map)) {
            return $values;
        }

        foreach ($this->map as $field => $converter) {
            if (!array_key_exists($field, $values)) {
                throw new \RuntimeException(sprintf('Column "%s" not found to apply conversion', $field));
            }
            $values[$field] = $converter($values[$field]);
        }
    }
}
