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
        $csvOutputFilePathname = str_replace('.' . $outputFile->getExtension(), '.csv', $localPath);

        $opts = [
            'header' => true,
            'delimiter' => "\t",
        ];
        foreach (['columns','delimiter','enclosure','header','replace_file'] as $option) {
            if (array_key_exists($option, $options)) {
                $opts[$option] = $options[$option];
            }
        }

        parent::__construct($csvOutputFilePathname, $opts);

        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'replace_file' => false,
            'delimiter' => $opts['delimiter'],
            'enclosure' => '"',
            'header' => $opts['header'],
            'autoincrement_field' => false,
            'drop_data' => false,
            'create_table' => false,
            'columns' => [],
        ]);

        $this->options = $resolver->resolve(array_merge($options, $opts));

        $this->sqlOutputFilePathname = $localPath;
        $this->tableName = $tableName;
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

        $dropRecordsString = $this->options['drop_data'] ? sprintf("\n" . 'DELETE FROM %s;', $this->tableName) : null;
        $autoIncrementString = $this->options['autoincrement_field'] ? sprintf('SET %s = NULL', $this->options['autoincrement_field']) : null;
        $rowsToIgnore = $this->options['header'] ? 1 : 0;
        $headers = '(' . implode(', ', $this->headers) . ')';

        $delimiter = str_replace(["\t","\n","\r"], ['\\t','\\n','\\r'], $this->options['delimiter']);
        $enclosure = $this->options['enclosure'];

        $createTableSql = null;
        if ($this->options['create_table']) {
            $h = fopen($this->outputFilePathname, 'r');
            $columnNames = fgetcsv($h, 0, $this->options['delimiter'], $this->options['enclosure']);

            $autoIncrementField = $this->options['autoincrement_field'] ? $this->options['autoincrement_field'] . ' int auto_increment not null, ' : '';
            $primaryKeyField = $this->options['autoincrement_field'] ? ', primary key (' . $this->options['autoincrement_field'] . ')' : '';
            $createTableSql = sprintf('DROP TABLE IF EXISTS %s;CREATE TABLE %s (%s%s%s);', $this->tableName, $this->tableName, $autoIncrementField, implode(', ', array_map(function ($value) {
                return $value . ' text';
            }, $columnNames)), $primaryKeyField);
        }

        $contents = <<<SQL
{$createTableSql}{$dropRecordsString}        
LOAD DATA LOCAL INFILE '{$this->outputFilePathname}' 
INTO TABLE {$this->tableName}
CHARACTER SET utf8
FIELDS 
    TERMINATED BY '{$delimiter}'
    ENCLOSED BY '{$enclosure}'
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
