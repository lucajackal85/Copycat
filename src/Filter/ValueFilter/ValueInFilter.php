<?php


namespace Jackal\Copycat\Filter\ValueFilter;

class ValueInFilter extends AbstractFilter
{
    private $valueToSearch;

    public function __construct($fieldName, array $valuesToSearch)
    {
        parent::__construct($fieldName);
        $this->valueToSearch = $valuesToSearch;
    }

    public function __invoke($value)
    {
        return in_array($value[$this->fieldName], $this->valueToSearch);
    }
}
