<?php


namespace Jackal\Copycat\Writer;

use Exception;
use InvalidArgumentException;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SQLFileWriter
 * @package Jackal\Copycat\Writer
 */
class SQLFileWriter implements WriterInterface
{
    /**
     * @var string
     */
    protected $outputFilePathname;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * @var int
     */
    protected $index;

    /**
     * @var array
     */
    protected $cols = [];

    /**
     * SQLFileWriter constructor.
     * @param $tableName
     * @param $outputFilePathname
     * @param array $options
     */
    public function __construct($tableName, $outputFilePathname, array $options = [])
    {
        $this->tableName = $tableName;
        $this->outputFilePathname = $outputFilePathname;

        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'replace_file' => false,
            'columns' => [],
            'exception_on_extra_columns' => false,
            'drop_data' => false
        ]);

        $this->options = $resolver->resolve($options);
    }

    /**
     * @param $content
     */
    private function appendRow($content)
    {
        file_put_contents($this->outputFilePathname, $content, FILE_APPEND);
    }

    /**
     * @param array $item
     */
    public function writeItem(array $item)
    {
        if ($this->index == 0) {
            if (!$this->options['columns']) {
                $this->cols = array_keys($item);
            } else {
                $this->cols = $this->options['columns'];
            }
        }

        //raise exception on extra columns
        if ($this->options['exception_on_extra_columns']) {
            $extraColumns = [];
            foreach (array_keys($item) as $itemKey) {
                if (!in_array($itemKey, $this->cols)) {
                    $extraColumns[] = $itemKey;
                }
            }
            if ($extraColumns) {
                throw new InvalidArgumentException(sprintf(
                    'Row %s had extra columns %s. (Defined columns: %s)',
                    $this->index + 1,
                    "\"".implode('", "', $extraColumns)."\"",
                    "\"".implode('", "', $this->cols)."\""
                ));
            }
        }

        //Fill array maintain defined order
        foreach ($this->cols as $key => $colName) {
            if (!array_key_exists($colName, $item)) {
                $item[$colName] = null;
            }
        }

        $itemOrdered = [];
        $colOrder = array_flip($this->cols);
        foreach ($colOrder as $colKey => $colValue) {
            $itemOrdered[$colKey] = $item[$colKey];
        }
        $item = $itemOrdered;


        if ($this->index == 0) {
            if ($this->options['drop_data']) {
                $this->appendRow(sprintf("delete from %s\n", $this->tableName));
            }
            $this->appendRow(sprintf("insert into %s (%s) values\n", $this->tableName, implode(', ', array_keys($item))));
        } else {
            $this->appendRow(",\n");
        }


        $item = array_reduce($item, function ($outCell, $currentCell) {
            if (is_null($currentCell)) {
                $outCell[] = 'null';
                return $outCell;
            }
            //escape sql string
            $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
            $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
            $outCell[] = '"'.str_replace($search, $replace, $currentCell).'"';
            return $outCell;
        }, []);


        $rowString = sprintf('(%s)', implode(', ', array_values($item)));
        $this->appendRow($rowString);
        $this->index++;
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
    }

    /**
     *
     */
    public function finish()
    {
        $this->appendRow(';');
    }
}
