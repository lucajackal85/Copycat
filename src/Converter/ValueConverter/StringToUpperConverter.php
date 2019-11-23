<?php


namespace Jackal\Copycat\Converter\ValueConverter;

/**
 * Class StringToUpperConverter
 * @package Jackal\Copycat\Converter\ValueConverter
 */
class StringToUpperConverter extends AbstractConverter
{
    /**
     * @param $value
     * @return mixed
     */
    public function __invoke($value)
    {
        $value[$this->fieldName] = mb_strtoupper($value[$this->fieldName]);

        return $value;
    }
}
