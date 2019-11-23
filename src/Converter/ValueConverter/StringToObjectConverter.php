<?php


namespace Jackal\Copycat\Converter\ValueConverter;

/**
 * Class StringToObjectConverter
 * @package Jackal\Copycat\Converter\ValueConverter
 */
class StringToObjectConverter extends AbstractConverter
{
    /**
     * @param $value
     * @return mixed
     */
    public function __invoke($value)
    {
        $value[$this->fieldName] = unserialize($value[$this->fieldName]);

        return $value;
    }
}
