<?php


namespace Jackal\Copycat\Filter\ValueFilter;


class GreaterThanFilter extends AbstractFilter
{
    private $comparedValue;

    public function __construct($fieldName,$comparedValue = 0)
    {
        parent::__construct($fieldName);
        $this->comparedValue = $comparedValue;
    }

    public function __invoke($value)
    {
        return (isset($value[$this->fieldName]) and is_numeric($value[$this->fieldName]) and $value[$this->fieldName] > $this->comparedValue) ;
    }
}