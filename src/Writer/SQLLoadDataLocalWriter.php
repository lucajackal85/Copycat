<?php


namespace Jackal\Copycat\Writer;

use Symfony\Component\OptionsResolver\OptionsResolver;

class SQLLoadDataLocalWriter extends CSVFileWriter
{
    protected $sqlOutputFilePathname;
    protected $tablename;
    protected $headers = [];

    public function __construct($tablename, $outputFilePathname, $options = [])
    {
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

        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'replace_file' => false,
            'delimiter' => ',',
            'enclosure' => '"',
            'header' => true,
            'autoincrement_field' => false,
            'drop_data' => false,
            'columns' => []
        ]);

        $this->options = $resolver->resolve($options);
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

        $dropRecordsString = $this->options['drop_data'] ? sprintf('DELETE FROM %s;', $this->tablename) : null;
        $autoincrementtring = $this->options['autoincrement_field'] ? sprintf('SET %s = NULL', $this->options['autoincrement_field']) : null;
        $rowsToIgnore = $this->options['header'] ? 1 : 0;
        $headers = '('.implode(', ', $this->headers).')';

        $contents = <<<SQL
{$dropRecordsString}        
LOAD DATA LOCAL INFILE '{$this->outputFilePathname}' 
INTO TABLE {$this->tablename}
CHARACTER SET utf8
FIELDS 
    TERMINATED BY '\\t'
    ENCLOSED BY '{$this->options['enclosure']}'
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
