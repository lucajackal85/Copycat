<?php


namespace Jackal\Copycat\Converter\ValueConverter;

/**
 * Class AbstractConverter
 * @package Jackal\Copycat\Converter\ValueConverter
 */
abstract class AbstractConverter implements ConverterInterface
{
    /**
     * @var string
     */
    protected $fieldName;

    /**
     * AbstractConverter constructor.
     * @param $fieldName
     */
    public function __construct($fieldName)
    {
        $this->fieldName = $fieldName;
    }
}
