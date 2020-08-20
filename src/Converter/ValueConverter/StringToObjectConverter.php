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
        $object = @unserialize($value[$this->fieldName]);

        if($object === false and $value[$this->fieldName] !== serialize(false)){
            throw new \RuntimeException('Error converting string to object.');
        }
        $value[$this->fieldName] = $object;

        return $value;
    }
}
