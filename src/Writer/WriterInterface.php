<?php


namespace Jackal\Copycat\Writer;


interface WriterInterface
{
    public function prepare();
    public function writeItem(array $item);
    public function finish();
}