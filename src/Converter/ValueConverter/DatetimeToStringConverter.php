<?php


namespace Jackal\Copycat\Converter\ValueConverter;

class DatetimeToStringConverter extends AbstractConverter
{
    protected $format;

    public function __construct($fieldName, $format = 'Y-m-d H:i:s')
    {
        parent::__construct($fieldName);
        $this->format = $format;
    }

    public function __invoke($value)
    {
        if (!$value[$this->fieldName]) {
            return null;
        }
        if (!($value[$this->fieldName] instanceof \DateTime)) {
            throw new \RuntimeException('Input must be DateTime object.');
        }
        $value[$this->fieldName] = $value[$this->fieldName]->format($this->format);

        return $value;
    }
}
