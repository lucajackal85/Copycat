<?php


namespace Jackal\Copycat\Converter\ValueConverter;

/**
 * Class JSONToArrayConverter
 * @package Jackal\Copycat\Converter\ValueConverter
 */
class JSONToArrayConverter extends AbstractConverter
{
    /**
     * @param $value
     * @return mixed
     */
    public function __invoke($value)
    {
        $value[$this->fieldName] = json_decode($value[$this->fieldName], true);

        return $value;
    }
}
