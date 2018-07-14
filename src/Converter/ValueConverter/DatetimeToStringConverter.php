<?php


namespace Jackal\Copycat\Converter\ValueConverter;


class DatetimeToStringConverter implements ConverterInterface
{
    protected $format;

    public function __construct($format = 'Y-m-d H:i:s')
    {
        $this->format = $format;
    }

    public function __invoke($value)
    {
        if (!$value) {
            return null;
        }
        if (!($value instanceof \DateTime)) {
            throw new \RuntimeException('Input must be DateTime object.');
        }
        return $value->format($this->format);
    }
}