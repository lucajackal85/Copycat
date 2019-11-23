<?php


namespace Jackal\Copycat\Sorter\ValueSorter;

use Jackal\Copycat\Sorter\SorterInterface;

/**
 * Class AscendingSorter
 * @package Jackal\Copycat\Sorter\ValueSorter
 */
class AscendingSorter implements SorterInterface
{
    /**
     * @var array
     */
    protected $fieldNames;

    /**
     * @return int
     */
    protected function getOrder()
    {
        return SORT_ASC;
    }

    /**
     * AscendingSorter constructor.
     * @param mixed ...$fieldName
     */
    public function __construct(...$fieldName)
    {
        $this->fieldNames = func_get_args();
    }

    /**
     * @param $values
     * @return array|mixed
     */
    public function __invoke(&$values)
    {
        $orderColumns = [];
        foreach ($this->fieldNames as $fieldName) {
            $orderColumns[$fieldName] = $this->getOrder();
        }

        $values = array_values($this->array_mSort($values, $orderColumns));

        return $values;
    }

    /**
     * @param $array
     * @param $cols
     * @return array
     * Taken from https://www.php.net/manual/en/function.array-multisort.php
     */
    private function array_mSort($array, $cols)
    {
        $colArr = array();
        foreach ($cols as $col => $order) {
            $colArr[$col] = array();
            foreach ($array as $k => $row) {
                $colArr[$col]['_'.$k] = strtolower($row[$col]);
            }
        }
        /** @noinspection SpellCheckingInspection */
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colArr[\''.$col.'\'],'.$order.',';
        }
        $eval = substr($eval, 0, -1).');';
        eval($eval);
        $ret = array();
        foreach ($colArr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k, 1);
                if (!isset($ret[$k])) {
                    $ret[$k] = $array[$k];
                }
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return $ret;
    }
}
