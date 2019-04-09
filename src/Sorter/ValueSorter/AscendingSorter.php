<?php


namespace Jackal\Copycat\Sorter\ValueSorter;

use Jackal\Copycat\Sorter\SorterInterface;

class AscendingSorter implements SorterInterface
{
    protected $fieldNames;

    protected function getOrder(){
        return SORT_ASC;
    }

    public function __construct(...$fieldName)
    {
        $this->fieldNames = func_get_args();
    }

    public function __invoke(&$values)
    {
        $orderColumns = [];
        foreach ($this->fieldNames as $fieldName){
            $orderColumns[$fieldName] = $this->getOrder();
        }

        $values = array_values($this->array_msort($values,$orderColumns));

        return $values;

    }

    /* Taken from https://www.php.net/manual/en/function.array-multisort.php */
    private function array_msort($array, $cols)
    {
        $colarr = array();
        foreach ($cols as $col => $order) {
            $colarr[$col] = array();
            foreach ($array as $k => $row) { $colarr[$col]['_'.$k] = strtolower($row[$col]); }
        }
        $eval = 'array_multisort(';
        foreach ($cols as $col => $order) {
            $eval .= '$colarr[\''.$col.'\'],'.$order.',';
        }
        $eval = substr($eval,0,-1).');';
        eval($eval);
        $ret = array();
        foreach ($colarr as $col => $arr) {
            foreach ($arr as $k => $v) {
                $k = substr($k,1);
                if (!isset($ret[$k])) $ret[$k] = $array[$k];
                $ret[$k][$col] = $array[$k][$col];
            }
        }
        return $ret;

    }
}