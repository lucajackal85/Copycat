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
    protected $allowNulls;

    /**
     * DatetimeToStringConverter constructor.
     * @param $fieldName
     * @param string $format
     */
    public function __construct($fieldName, $outputFormat = 'Y-m-d H:i:s',$allowNulls = false)
    {
        parent::__construct($fieldName);
        $this->format = $outputFormat;
        $this->allowNulls = $allowNulls;
    }

    /**
     * @param $value
     * @return mixed|null
     */
    public function __invoke($value)
    {
        $dateValue = &$value[$this->fieldName];

        if ($dateValue === null) {
            if($this->allowNulls == false){
                throw new RuntimeException('Input must be DateTime object.');
            }else{
                $dateValue = null;
            }
        }else {
            if (!($dateValue instanceof DateTime)) {
                throw new RuntimeException('Input must be DateTime object.');
            }

            $dateValue = $dateValue->format($this->format);
        }
        return $value;
    }
}
