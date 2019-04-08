<?php


namespace Jackal\Copycat\Filter\ValueFilter;

class LowerThanFilter extends AbstractFilter
{
    private $comparedValue;

    public function __construct($fieldName, $comparedValue = 0)
    {
        parent::__construct($fieldName);
        $this->comparedValue = $comparedValue;
    }

    public function __invoke($value)
    {
        $val = $value[$this->fieldName];

        switch (true) {
            case !isset($val):
                return false;
            case is_numeric($val) or is_string($val):
                return $val < $this->comparedValue;
            case $val instanceof \DateTime:{
                if ($this->comparedValue instanceof \DateTime) {
                    $this->comparedValue = $this->comparedValue->format('Y-m-d H:i:s');
                }
                return $val->format('Y-m-d H:i:s') < $this->comparedValue;
            }
        }
    }
}
