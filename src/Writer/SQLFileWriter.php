<?php


namespace Jackal\Copycat\Writer;

use http\Exception\InvalidArgumentException;

class SQLFileWriter implements WriterInterface
{
    const OPT_REPLACE_FILE = 'replace_file';
    const OPT_DEFINED_COLUMNS = 'defined_columns';
    const OPT_EXCEPTION_ON_DIFF_COLUMNS = 'exception_on_diff_columns';

    protected $outputFilePathname;
    protected $tablename;
    protected $options;
    protected $index;
    protected $cols = [];

    public function __construct($tablename, $outputFilePathname, array $options = [])
    {
        $this->tablename = $tablename;
        $this->outputFilePathname = $outputFilePathname;
        $this->options = array_merge([
            self::OPT_REPLACE_FILE => false,
            self::OPT_DEFINED_COLUMNS => [],
            self::OPT_EXCEPTION_ON_DIFF_COLUMNS => false
        ],$options);
    }

    private function appendRow($content)
    {
        file_put_contents($this->outputFilePathname, $content, FILE_APPEND);
    }

    public function writeItem(array $item)
    {
        if ($this->index == 0) {
            if (!$this->options[self::OPT_DEFINED_COLUMNS]) {
                $this->cols = array_keys($item);
            } else {
                $this->cols = $this->options[self::OPT_DEFINED_COLUMNS];
            }
        }

        //raise exception on extra columns
        if($this->options[self::OPT_EXCEPTION_ON_DIFF_COLUMNS]){
            $extraColumns = [];
            foreach (array_keys($item) as $itemKey){
                if(!in_array($itemKey,$this->cols)){
                    $extraColumns[] = $itemKey;
                }
            }
            if($extraColumns) {
                throw new \InvalidArgumentException(sprintf('Row %s had extra columns %s. (Defined columns: %s)',
                    $this->index + 1,
                    "\"".implode('", "',$extraColumns)."\"",
                    "\"".implode('", "',$this->cols)."\""
                ));
            }
        }

        //Fill array maintain defined order
        foreach ($this->cols as $key => $colName) {
            if(!array_key_exists($colName, $item)){
                $item[$colName] = null;
            }
        }

        $itemOrdered = [];
        $colOrder = array_flip($this->cols);
        foreach($colOrder as $colKey => $colValue){
            $itemOrdered[$colKey] = $item[$colKey];
        }
        $item = $itemOrdered;


        if ($this->index == 0) {
            $headString = sprintf("insert into %s (%s) values\n", $this->tablename, implode(', ', array_keys($item)));
            $this->appendRow($headString);
        } else {
            $this->appendRow(",\n");
        }


        $item = array_reduce($item, function ($outCell, $currentCell) {
            if(is_null($currentCell)){
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

    public function prepare()
    {
        if (!is_dir(dirname($this->outputFilePathname))) {
            mkdir(dirname($this->outputFilePathname), 0775, true);
        }

        $fileExists = file_exists($this->outputFilePathname);
        if ($fileExists and !$this->options[self::OPT_REPLACE_FILE]) {
            throw new \Exception('File '.realpath($this->outputFilePathname).' already exists');
        }

        if ($fileExists) {
            unlink($this->outputFilePathname);
        }
    }

    public function finish()
    {
        $this->appendRow(';');
    }
}
