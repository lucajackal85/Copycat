<?php


namespace Jackal\Copycat;


use Jackal\Copycat\Converter\ConversionMap;
use Jackal\Copycat\Converter\ValueConverter\ConverterInterface;
use Jackal\Copycat\Reader\ReaderInterface;
use Jackal\Copycat\Writer\WriterInterface;

class Workflow
{
    /**
     * @var ReaderInterface
     */
    protected $reader;

    /**
     * @var WriterInterface[]
     */
    protected $writers = [];

    /**
     * @var ConversionMap
     */
    protected $conversionMap;

    public function __construct(ReaderInterface $reader)
    {
        $this->reader = $reader;
        $this->conversionMap = new ConversionMap();
    }

    public function addWriter(WriterInterface $writer){
        $this->writers[] = $writer;
    }

    public function addConverter($column,callable $converter){
        $this->conversionMap->add($column,$converter);
    }

    public function process(){
        if(!$this->reader){
            throw new \RuntimeException('No reader set');
        }

        if(!$this->writers){
            throw new \RuntimeException('No writers set');
        }

        foreach($this->writers as $writer) {
            $writer->prepare();
        }

        foreach ($this->reader as $k => $row) {
            foreach($this->writers as $writer) {
                $this->conversionMap->apply($row);
                $writer->writeItem($row);
            }
        }

        foreach($this->writers as $writer) {
            $writer->finish();
        }
    }
}