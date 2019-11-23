<?php


namespace Jackal\Copycat\Writer;

use Exception;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CSVFileWriter
 * @package Jackal\Copycat\Writer
 */
class CSVFileWriter implements WriterInterface
{
    /**
     * @var string
     */
    protected $outputFilePathname;

    /**
     * @var resource
     */
    protected $handle;

    /**
     * @var int
     */
    protected $index = 0;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * CSVFileWriter constructor.
     * @param $outputFilePathname
     * @param array $options
     */
    public function __construct($outputFilePathname, array $options = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'replace_file' => false,
            'delimiter' => ',',
            'enclosure' => '"',
            'header' => true,
            'columns' => []
        ]);

        $this->options = $resolver->resolve($options);

        $this->outputFilePathname = $outputFilePathname;

        if (!is_dir(dirname($this->outputFilePathname))) {
            mkdir(dirname($this->outputFilePathname), 0775, true);
        }
    }

    /**
     * @throws Exception
     */
    public function prepare()
    {
        if (!is_dir(dirname($this->outputFilePathname))) {
            mkdir(dirname($this->outputFilePathname), 0775, true);
        }

        $fileExists = file_exists($this->outputFilePathname);
        if ($fileExists and !$this->options['replace_file']) {
            throw new Exception('File '.realpath($this->outputFilePathname).' already exists');
        }

        if ($fileExists) {
            unlink($this->outputFilePathname);
        }

        $this->handle = fopen($this->outputFilePathname, 'w');
    }

    /**
     * @param array $item
     */
    public function writeItem(array $item)
    {
        if ($this->options['columns'] and array_keys($item) != $this->options['columns']) {
            $itemOrdered = [];
            foreach ($this->options['columns'] as $orderedColumn) {
                if (!array_key_exists($orderedColumn, $item)) {
                    $itemOrdered[$orderedColumn] = null;
                } else {
                    $itemOrdered[$orderedColumn] = $item[$orderedColumn];
                }
            }
            $item = $itemOrdered;
        }

        if ($this->index == 0 and $this->options['header']) {
            fputcsv($this->handle, array_keys($item), $this->options['delimiter'], $this->options['enclosure']);
        }
        fputcsv($this->handle, array_values($item), $this->options['delimiter'], $this->options['enclosure']);
        $this->index++;
    }

    /**
     *
     */
    public function finish()
    {
        fclose($this->handle);
    }
}
