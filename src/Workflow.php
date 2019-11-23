<?php


namespace Jackal\Copycat;

use Jackal\Copycat\Converter\ConversionMap;
use Jackal\Copycat\Filter\FilterMap;
use Jackal\Copycat\Reader\ReaderInterface;
use Jackal\Copycat\Sorter\SorterMap;
use Jackal\Copycat\Writer\WriterInterface;
use RuntimeException;

/**
 * Class Workflow
 * @package Jackal\Copycat
 */
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
     * @var SorterMap
     */
    protected $sorterMap;

    /**
     * Workflow constructor.
     * @param ReaderInterface $reader
     */
    public function __construct(ReaderInterface $reader)
    {
        $this->reader = $reader;
        $this->conversionMap = new ConversionMap();
        $this->filterMap = new FilterMap();
        $this->sorterMap = new SorterMap();
    }

    /**
     * @param WriterInterface $writer
     */
    public function addWriter(WriterInterface $writer)
    {
        $this->writers[] = $writer;
    }

    /**
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

    /**
     * @param callable $sorter
     */
    public function addSorter(callable $sorter)
    {
        $this->sorterMap->add($sorter);
    }

    /**
     * @param callable|null $callback
     */
    public function process(callable $callback = null)
    {
        if (!$this->writers) {
            throw new RuntimeException('No writers set');
        }

        foreach ($this->writers as $writer) {
            $writer->prepare();
        }

        if ($this->sorterMap->hasSorter()) {
            $values = $this->reader->all();
            $this->sorterMap->apply($values);
        } else {
            $values = $this->reader;
        }

        foreach ($values as $k => $row) {
            foreach ($this->writers as $writer) {
                $copyRow = $row;
                $this->conversionMap->apply($copyRow);
                if ($this->filterMap->apply($copyRow)) {
                    $writer->writeItem($copyRow);
                }
            }

            if ($callback) {
                if (isset($copyRow)) {
                    $callback($copyRow);
                }
            }
        }

        foreach ($this->writers as $writer) {
            $writer->finish();
        }
    }
}
