<?php


namespace Jackal\Copycat\Converter\ValueConverter;

use DateTime;
use RuntimeException;

/**
 * Class DatetimeToStringConverter
 * @package Jackal\Copycat\Converter\ValueConverter
 */
class DatetimeToStringConverter extends AbstractConverter
{
    /**
     * @var string
     */
    protected $format;

    /**
     * DatetimeToStringConverter constructor.
     * @param $fieldName
     * @param string $format
     */
    public function __construct($fieldName, $format = 'Y-m-d H:i:s')
    {
        parent::__construct($fieldName);
        $this->format = $format;
    }

    /**
     * @param $value
     * @return mixed|null
     */
    public function __invoke($value)
    {
        $dateValue = &$value[$this->fieldName];

        if (!$dateValue) {
            return null;
        }
        if (!($dateValue instanceof DateTime)) {
            throw new RuntimeException('Input must be DateTime object.');
        }

        $dateValue = $dateValue->format($this->format);

        return $value;
    }
}
