<?php


namespace Jackal\Copycat\Writer;

class SQLLoadDataLocalWriter extends CSVFileWriter
{
    protected $sqlOutputFilePathname;
    protected $tablename;

    protected $headers = [];

    const OPT_AUTOINCREMENT_FIELD = 'autoincrement_field';
    const OPT_DROP_RECORD = 'drop_record';

    public function __construct($tablename, $outputFilePathname, $options = [])
    {
        $options = array_merge([
            self::OPT_AUTOINCREMENT_FIELD => false,
            self::OPT_REPLACE_FILE => false,
            self::OPT_DELIMITER => ',',
            self::OPT_ENCLOSURE => '"',
            self::OPT_HEADER => true,
            self::OPT_DROP_RECORD => false
        ],$options);

        if (!is_dir(dirname($outputFilePathname))) {
            mkdir(dirname($outputFilePathname), 0775, true);
        }

        touch($outputFilePathname);

        $outputFile = new \SplFileInfo($outputFilePathname);

        $localPath = realpath($outputFile->getPathname());
        $csvOutputFilePathname = str_replace('.'.$outputFile->getExtension(), '.csv', $localPath);

        parent::__construct($csvOutputFilePathname, $options);
        $this->sqlOutputFilePathname = $localPath;
        $this->tablename = $tablename;
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

        $dropRecordsString = $this->options[self::OPT_DROP_RECORD] ? sprintf('DELETE FROM %s;', $this->tablename) : null;
        $autoincrementtring = $this->options[self::OPT_AUTOINCREMENT_FIELD] ? sprintf('SET %s = NULL', $this->options[self::OPT_AUTOINCREMENT_FIELD]) : null;
        $rowsToIgnore = $this->options[self::OPT_HEADER] ? 1 : 0;
        $headers = '('.implode(', ', $this->headers).')';

        $contents = <<<SQL
{$dropRecordsString}        
LOAD DATA LOCAL INFILE '{$this->outputFilePathname}' 
INTO TABLE {$this->tablename}
CHARACTER SET utf8
FIELDS 
    TERMINATED BY '\\t'
    ENCLOSED BY '{$this->options[self::OPT_ENCLOSURE]}'
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
