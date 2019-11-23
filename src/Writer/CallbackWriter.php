<?php

namespace Jackal\Copycat\Writer;

/**
 * Class CallbackWriter
 * @package Jackal\Copycat\Writer
 */
class CallbackWriter implements WriterInterface
{
    /**
     * @var callable
     */
    protected $callback;

    /**
     * CallbackWriter constructor.
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
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
        call_user_func($this->callback, $item);
    }

    public function finish()
    {
        //do nothing
    }
}
