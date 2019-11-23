<?php


namespace Jackal\Copycat\Converter\ValueConverter;

use DateTime;
use Exception;

/**
 * Class StringToDateTimeConverter
 * @package Jackal\Copycat\Converter\ValueConverter
 */
class StringToDateTimeConverter extends AbstractConverter
{
    /**
     * @param $value
     * @return mixed
     * @throws Exception
     */
    public function __invoke($value)
    {
        $value[$this->fieldName] = new DateTime($value[$this->fieldName]);

        return $value;
    }
}
