<?php

namespace Jackal\Copycat\Filter\ValueFilter;

use DateTime;

/**
 * Class GreaterThanFilter
 * @package Jackal\Copycat\Filter\ValueFilter
 */
class GreaterThanFilter extends AbstractFilter
{
    /**
     * @var
     */
    private $comparedValue;

    /**
     * GreaterThanFilter constructor.
     * @param $fieldName
     * @param $comparedValue
     */
    public function __construct($fieldName, $comparedValue)
    {
        parent::__construct($fieldName);
        $this->comparedValue = $comparedValue;
    }

    /**
     * @param $value
     * @return bool
     */
    public function __invoke($value)
    {
        $val = $value[$this->fieldName];
        switch (true) {
            case !isset($val):
                return true;
            case is_numeric($val) or is_string($val):
                return $val > $this->comparedValue;
            case $val instanceof DateTime:{
                if ($this->comparedValue instanceof DateTime) {
                    $this->comparedValue = $this->comparedValue->format('Y-m-d H:i:s');
                }

                return $val->format('Y-m-d H:i:s') > $this->comparedValue;
            }
        }
    }
}
