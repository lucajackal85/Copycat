<?php


namespace Jackal\Copycat\Filter\ValueFilter;

/**
 * Interface FilterInterface
 * @package Jackal\Copycat\Filter\ValueFilter
 */
interface FilterInterface
{
    /**
     * @param $value
     * @return mixed
     */
    public function __invoke($value);
}
