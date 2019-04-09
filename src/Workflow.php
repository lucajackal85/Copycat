<?php


namespace Jackal\Copycat;

use Jackal\Copycat\Converter\ConversionMap;
use Jackal\Copycat\Converter\ValueConverter\ConverterInterface;
use Jackal\Copycat\Filter\FilterInterface;
use Jackal\Copycat\Filter\FilterMap;
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

    /**
     * @var FilterMap
     */
    protected $filterMap;

    /**
     * Workflow constructor.
     * @param ReaderInterface $reader
     */
    public function __construct(ReaderInterface $reader)
    {
        $this->reader = $reader;
        $this->conversionMap = new ConversionMap();
        $this->filterMap = new FilterMap();
    }

    /**
     * @param WriterInterface $writer
     */
    public function addWriter(WriterInterface $writer)
    {
        $this->writers[] = $writer;
    }

    /**
     * @param $column
     * @param callable $converter
     */
    public function addConverter(callable $converter)
    {
        $this->conversionMap->add($converter);
    }

    /**
     * @param callable $filter
     */
    public function addFilter(callable $filter)
    {
        $this->filterMap->add($filter);
    }

    public function process()
    {
        if (!$this->writers) {
            throw new \RuntimeException('No writers set');
        }

        foreach ($this->writers as $writer) {
            $writer->prepare();
        }

        foreach ($this->reader as $k => $row) {
            foreach ($this->writers as $writer) {
                $copyRow = $row;
                $this->conversionMap->apply($copyRow);
                if ($this->filterMap->apply($copyRow)) {
                    $writer->writeItem($copyRow);
                }
            }
        }

        foreach ($this->writers as $writer) {
            $writer->finish();
        }
    }
}
