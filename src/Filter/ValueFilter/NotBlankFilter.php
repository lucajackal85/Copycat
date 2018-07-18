<?php


namespace Jackal\Copycat\Filter\ValueFilter;


class NotBlankFilter implements FilterInterface
{
    private $fieldName;
    public function __construct($fieldName)
    {
        $this->fieldName = $fieldName;
    }

    public function __invoke($value)
    {
        return (isset($value[$this->fieldName]) and strlen($value[$this->fieldName]) > 0) ;
    }
}