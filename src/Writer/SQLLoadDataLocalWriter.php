<?php


namespace Jackal\Copycat\Writer;

class SQLLoadDataLocalWriter extends CSVFileWriter
{
    protected $sqlOutputFilePathname;
    protected $tablename;
    protected $enclosure = '"';
    protected $delimiter = "\t";
    protected $autoincrementField;
    protected $dropRecords = false;

    protected $headers = [];

    public function __construct($tablename, $outputFilePathname, $replaceFile = false, $autoincrementField = null, $dropRecords = false)
    {
        if (!is_dir(dirname($outputFilePathname))) {
            mkdir(dirname($outputFilePathname), 0775, true);
        }

        touch($outputFilePathname);

        $outputFile = new \SplFileInfo($outputFilePathname);

        $localPath = realpath($outputFile->getPathname());
        $csvOutputFilePathname = str_replace('.'.$outputFile->getExtension(), '.csv', $localPath);

        parent::__construct($csvOutputFilePathname, $replaceFile, $this->delimiter, $this->enclosure, true);
        $this->sqlOutputFilePathname = $localPath;
        $this->tablename = $tablename;
        $this->autoincrementField = $autoincrementField;
        $this->dropRecords = $dropRecords;
    }

    public function writeItem(array $item)
    {
        if ($this->index == 0) {
            $this->headers = array_keys($item);
        }
        parent::writeItem($item);
    }

    public function finish()
    {
        parent::finish();

        $dropRecordsString = $this->dropRecords ? sprintf('DELETE FROM %s;', $this->tablename) : null;
        $autoincrementtring = $this->autoincrementField ? sprintf('SET %s = NULL', $this->autoincrementField) : null;
        $rowsToIgnore = $this->writeHeader ? 1 : 0;
        $headers = '('.implode(', ', $this->headers).')';

        $contents = <<<SQL
{$dropRecordsString}        
LOAD DATA LOCAL INFILE '{$this->outputFilePathname}' 
INTO TABLE {$this->tablename}
CHARACTER SET utf8
FIELDS 
    TERMINATED BY '\\t'
    ENCLOSED BY '{$this->enclosure}'
    ESCAPED BY ''
LINES 
    TERMINATED BY '\\n'
IGNORE $rowsToIgnore LINES
$headers
$autoincrementtring
;
SQL;
        file_put_contents($this->sqlOutputFilePathname, $contents);
    }
}
