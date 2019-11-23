<?php


namespace Jackal\Copycat\Writer;

/**
 * Class ArrayWriter
 * @package Jackal\Copycat\Writer
 */
class ArrayWriter implements WriterInterface
{
    /**
     * @var array
     */
    protected $outItems;

    /**
     * ArrayWriter constructor.
     * @param $arrayToWrite
     */
    public function __construct(&$arrayToWrite)
    {
        if (!is_array($arrayToWrite)) {
            $arrayToWrite = [];
        }
        $this->outItems = &$arrayToWrite;
    }

    /**
     *
     */
    public function prepare()
    {
        //do nothing
    }

    /**
     * @param array $item
     */
    public function writeItem(array $item)
    {
        $this->outItems[] = $item;
    }

    /**
     *
     */
    public function finish()
    {
        //do nothing
    }
}
