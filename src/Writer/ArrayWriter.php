<?php


namespace Jackal\Copycat\Writer;

class ArrayWriter implements WriterInterface
{
    /**
     * @var array
     */
    private $outItems;

    public function __construct(array &$arrayToWrite)
    {
        $this->outItems = &$arrayToWrite;
    }

    public function prepare()
    {
        //do nothig
    }

    public function writeItem(array $item)
    {
        $this->outItems[] = $item;
    }

    public function finish()
    {
        //do nothing
    }
}
