<?php


namespace Jackal\Copycat\Filter\ValueFilter;


abstract class AbstractFilter implements FilterInterface
{
    protected $fieldName;

    public function __construct($fieldName)
    {
        $this->fieldName = $fieldName;
    }
}