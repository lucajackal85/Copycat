<?php


namespace Jackal\Copycat\Sorter;


interface SorterInterface
{
    public function __invoke(&$values);
}