<?php


namespace Jackal\Copycat\Writer;

class CSVFileWriter implements WriterInterface
{
    protected $outputFilePathname;
    protected $handle;
    protected $index = 0;

    protected $options = [];

    const OPT_REPLACE_FILE = 'replace_file';
    const OPT_DELIMITER = 'delimiter';
    const OPT_ENCLOSURE = 'enclosure';
    const OPT_HEADER = 'write_header';

    public function __construct($outputFilePathname, array $options = [])
    {
        $this->options = array_merge([
            self::OPT_REPLACE_FILE => false,
            self::OPT_DELIMITER => ',',
            self::OPT_ENCLOSURE => '"',
            self::OPT_HEADER => true
        ],$options);

        $this->outputFilePathname = $outputFilePathname;

        if (!is_dir(dirname($this->outputFilePathname))) {
            mkdir(dirname($this->outputFilePathname), 0775, true);
        }
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

        $this->handle = fopen($this->outputFilePathname, 'w');
    }

    public function writeItem(array $item)
    {
        if ($this->index == 0 and $this->options[self::OPT_HEADER]) {
            fputcsv($this->handle, array_keys($item), $this->options[self::OPT_DELIMITER], $this->options[self::OPT_ENCLOSURE]);
        }
        fputcsv($this->handle, array_values($item), $this->options[self::OPT_DELIMITER], $this->options[self::OPT_ENCLOSURE]);
        $this->index++;
    }

    public function finish()
    {
        fclose($this->handle);
    }
}
