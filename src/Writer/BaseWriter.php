<?php


namespace Jackal\Copycat\Writer;

/**
 * Class BaseWriter
 * @package Jackal\Copycat\Writer
 */
abstract class BaseWriter implements WriterInterface
{
    /**
     * @param array $item
     * @return mixed
     */
    abstract public function writeItem(array $item);
}
