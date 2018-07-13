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
     * @var WriterInterface[]
     */
    protected $writers;

    public function __construct(ReaderInterface $reader)
    {
        $this->reader = $reader;
    }

    public function addWriter(WriterInterface $writer){
        $this->writers[] = $writer;
    }

    public function process(){
        if(!$this->reader){
            throw new \RuntimeException('No reader set');
        }

        if(!$this->writers){
            throw new \RuntimeException('No writer set');
        }

        foreach($this->writers as $writer) {
            $writer->prepare();
        }

        $totalElement = $this->reader->count();
        foreach ($this->reader as $k => $row) {
            foreach($this->writers as $writer) {
                $writer->writeItem($row,($k+1),$totalElement);
            }
        }

        foreach($this->writers as $writer) {
            $writer->finish();
        }
    }
}