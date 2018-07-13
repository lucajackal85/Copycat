<?php


namespace Jackal\Importer\Writer;


interface WriterInterface
{
    public function prepare();
    public function writeItem(array $item);
    public function finish();
}