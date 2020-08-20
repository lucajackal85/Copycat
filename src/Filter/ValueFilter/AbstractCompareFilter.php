<?php


namespace Jackal\Copycat\Filter\ValueFilter;


abstract class AbstractCompareFilter extends AbstractFilter
{
    const COMPARISON_EQ = '=';
    const COMPARISON_GTE = '>=';
    const COMPARISON_GT = '>';
    const COMPARISON_LTE = '<=';
    const COMPARISON_LT = '<';

    abstract protected function getComparison();

    /**
     * @var int
     */
    private $comparedValue;

    /**
     * LowerThanFilter constructor.
     * @param $fieldName
     * @param int $comparedValue
     */
    public function __construct($fieldName, $comparedValue = 0)
    {
        parent::__construct($fieldName);

        $this->comparedValue = $comparedValue;
    }

    /**
     * @param $value
     * @return bool
     */
    public function __invoke($value)
    {
        return $this->applyComparison($value[$this->fieldName], $this->comparedValue,$this->getComparison());
    }

    protected function applyComparison($value1,$value2,$comparison){

        $value1 = $this->parseAsString($value1);
        $value2 = $this->parseAsString($value2);

        switch ($comparison){
            case self::COMPARISON_EQ:{
                if($value1 === null and $value2 === ''){
                    return true;
                }
                return $value1 === $value2;
            }
            case self::COMPARISON_LT:{
                return $value1 < $value2;
            }
            case self::COMPARISON_LTE:{
                return $value1 <= $value2;
            }
            case self::COMPARISON_GT:{
                return $value1 > $value2;
            }
            case self::COMPARISON_GTE:{

                return $value1 >= $value2;
            }
            default:{
                throw new \RuntimeException('Something went terribly wrong!');
            }
        }
    }

    /**
     * @param mixed $value
     * @return string|null
     */
    protected function parseAsString($value){

        if($value === null){
            return null;
        }
        if(is_scalar($value)){
            return $value;
        }

        if ($value instanceof \DateTime) {
            return $value->format('Y-m-d H:i:s');
        }

        if(is_object($value) and method_exists($value,'__toString')){
            return (string)$value;
        }

        throw new \RuntimeException('Cannot parse filter value');
    }


}