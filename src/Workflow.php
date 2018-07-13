<?php


namespace Jackal\Importer;


use Jackal\Importer\Reader\ReaderInterface;
use Jackal\Importer\Writer\WriterInterface;

class Workflow
{
    /**
     * @var ReaderInterface
     */
    protected $reader;

    /**
     * @var WriterInterface
     */
    protected $writer;

    public function addReader(ReaderInterface $reader){
        $this->reader = $reader;
    }

    public function addWriter(WriterInterface $writer){
        $this->writer = $writer;
    }

    public function process(){

        $this->writer->prepare();
        foreach ($this->reader as $row){
            $this->writer->writeItem($row);
        }
        $this->writer->finish();
    }
}