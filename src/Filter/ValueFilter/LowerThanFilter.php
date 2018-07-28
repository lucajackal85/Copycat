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
        switch (true) {
            case !isset($value[$this->fieldName]):
                return false;
            case is_numeric($value[$this->fieldName]) or is_string($value[$this->fieldName]):
                return $value[$this->fieldName] < $this->comparedValue;
            case $value[$this->fieldName] instanceof \DateTime:{
                if ($this->comparedValue instanceof \DateTime) {
                    $this->comparedValue = $this->comparedValue->format('Y-m-d H:i:s');
                }
                return ($value[$this->fieldName])->format('Y-m-d H:i:s') < $this->comparedValue;
            }
        }
    }
}
