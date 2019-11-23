<?php


namespace Jackal\Copycat\Writer;

use SplFileInfo;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SQLLoadDataLocalWriter
 * @package Jackal\Copycat\Writer
 */
class SQLLoadDataLocalWriter extends CSVFileWriter
{
    /**
     * @var string
     */
    protected $sqlOutputFilePathname;

    /**
     * @var string
     */
    protected $tableName;

    /**
     * @var array
     */
    protected $headers = [];

    /**
     * SQLLoadDataLocalWriter constructor.
     * @param $tableName
     * @param $outputFilePathname
     * @param array $options
     */
    public function __construct($tableName, $outputFilePathname, $options = [])
    {
        if (!is_dir(dirname($outputFilePathname))) {
            mkdir(dirname($outputFilePathname), 0775, true);
        }

        touch($outputFilePathname);

        $outputFile = new SplFileInfo($outputFilePathname);

        $localPath = realpath($outputFile->getPathname());
        $csvOutputFilePathname = str_replace('.'.$outputFile->getExtension(), '.csv', $localPath);

        parent::__construct($csvOutputFilePathname, $options);
        $this->sqlOutputFilePathname = $localPath;
        $this->tableName = $tableName;

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

    /**
     * @param array $item
     */
    public function writeItem(array $item)
    {
        if ($this->index == 0) {
            $this->headers = array_keys($item);
        }
        parent::writeItem($item);
    }

    /**
     *
     */
    public function finish()
    {
        parent::finish();

        $dropRecordsString = $this->options['drop_data'] ? sprintf('DELETE FROM %s;', $this->tableName) : null;
        $autoIncrementString = $this->options['autoincrement_field'] ? sprintf('SET %s = NULL', $this->options['autoincrement_field']) : null;
        $rowsToIgnore = $this->options['header'] ? 1 : 0;
        $headers = '('.implode(', ', $this->headers).')';

        $contents = <<<SQL
{$dropRecordsString}        
LOAD DATA LOCAL INFILE '{$this->outputFilePathname}' 
INTO TABLE {$this->tableName}
CHARACTER SET utf8
FIELDS 
    TERMINATED BY '\\t'
    ENCLOSED BY '{$this->options['enclosure']}'
    ESCAPED BY ''
LINES 
    TERMINATED BY '\\n'
IGNORE $rowsToIgnore LINES
$headers
$autoIncrementString
;
SQL;
        file_put_contents($this->sqlOutputFilePathname, $contents);
    }
}
