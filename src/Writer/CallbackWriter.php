<?php


namespace Jackal\Copycat\Writer;


class ArrayWriter implements WriterInterface
{
    protected $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function prepare()
    {
        //do nothing
    }

    public function writeItem(array $item, $currentIndex, $totalElements)
    {
        call_user_func($this->callback, $item);
    }

    public function finish()
    {
        //do nothing
    }
}