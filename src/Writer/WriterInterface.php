<?php


namespace Jackal\Copycat\Writer;

/**
 * Interface WriterInterface
 * @package Jackal\Copycat\Writer
 */
interface WriterInterface
{
    /**
     * @return mixed
     */
    public function prepare();

    /**
     * @param array $item
     * @return mixed
     */
    public function writeItem(array $item);

    /**
     * @return mixed
     */
    public function finish();
}
