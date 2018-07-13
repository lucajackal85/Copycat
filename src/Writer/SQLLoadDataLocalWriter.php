<?php


namespace Jackal\Importer\Writer;


class SQLLoadDataLocalWriter extends CSVFileWriter
{
    protected $sqlOutputFilePathname;
    protected $tablename;
    protected $enclosure = '"';

    public function __construct($tablename,$outputFilePathname, $replaceFile = false)
    {
        parent::__construct($outputFilePathname, $replaceFile, "\t", $this->enclosure, true);
        $this->sqlOutputFilePathname = dirname($this->outputFilePathname).DIRECTORY_SEPARATOR.basename($this->outputFilePathname,'.csv').'-loader.sql';
        $this->tablename = $tablename;
    }

    public function finish()
    {
        parent::finish();

        $contents = <<<SQL
LOAD DATA LOCAL INFILE '{$this->outputFilePathname}' INTO TABLE {$this->tablename}
  CHARACTER SET utf8
  FIELDS TERMINATED BY '\\t'
  ENCLOSED BY '{$this->enclosure}'
  LINES TERMINATED BY '\\n'
  IGNORE 1 ROWS;
SQL;
        file_put_contents($this->sqlOutputFilePathname,$contents);
    }


}