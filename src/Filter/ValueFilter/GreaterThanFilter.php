<?php


namespace Jackal\Copycat\Filter\ValueFilter;


class GreaterThanFilter implements FilterInterface
{

    private $fieldName;
    private $comparedValue;

    public function __construct($fieldName,$comparedValue = 0)
    {
        $this->fieldName = $fieldName;
        $this->comparedValue = $comparedValue;
    }

    public function __invoke($value)
    {
        return (isset($value[$this->fieldName]) and is_numeric($value[$this->fieldName]) and $value[$this->fieldName] > $this->comparedValue) ;
    }
}