<?php

namespace Jackal\Copycat\Filter\ValueFilter;

/**
 * Class AbstractFilter
 * @package Jackal\Copycat\Filter\ValueFilter
 */
abstract class AbstractFilter implements FilterInterface
{
    /**
     * @var string
     */
    protected $fieldName;

    /**
     * AbstractFilter constructor.
     * @param $fieldName
     */
    public function __construct($fieldName)
    {
        $this->fieldName = $fieldName;
    }
}
