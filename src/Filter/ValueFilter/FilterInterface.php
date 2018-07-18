<?php


namespace Jackal\Copycat\Filter\ValueFilter;


interface FilterInterface
{
    public function __invoke($value);
}