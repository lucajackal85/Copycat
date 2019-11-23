<?php


namespace Jackal\Copycat\Filter\ValueFilter;

/**
 * Class ValueInFilter
 * @package Jackal\Copycat\Filter\ValueFilter
 */
class ValueInFilter extends AbstractFilter
{
    /**
     * @var array
     */
    private $valueToSearch;

    /**
     * ValueInFilter constructor.
     * @param $fieldName
     * @param array $valuesToSearch
     */
    public function __construct($fieldName, array $valuesToSearch)
    {
        parent::__construct($fieldName);
        $this->valueToSearch = $valuesToSearch;
    }

    /**
     * @param $value
     * @return bool
     */
    public function __invoke($value)
    {
        return in_array($value[$this->fieldName], $this->valueToSearch);
    }
}
