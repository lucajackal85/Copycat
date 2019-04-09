<?php


namespace Jackal\Copycat\Converter\ValueConverter;

abstract class AbstractConverter implements ConverterInterface
{
    protected $fieldName;

    public function __construct($fieldName)
    {
        $this->fieldName = $fieldName;
    }
}
