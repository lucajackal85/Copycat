<?php


namespace Jackal\Copycat\Sorter\ValueSorter;


class DescendingSorter extends AscendingSorter
{
    protected function getOrder(){
        return SORT_DESC;
    }

}