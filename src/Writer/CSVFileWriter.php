<?php


namespace Jackal\Copycat\Writer;


class CSVFileWriter implements WriterInterface
{
    protected $outputFilePathname;
    protected $replaceFile;
    protected $handle;
    protected $delimiter;
    protected $enclosure;
    protected $writeHeader = true;
    protected $index = 0;

    public function __construct($outputFilePathname,$replaceFile = false,$delimiter = ',',$enclosure = '"',$writeHeader = true)
    {
        $this->outputFilePathname = $outputFilePathname;
        $this->replaceFile = $replaceFile;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
        $this->writeHeader = $writeHeader;
    }

    public function prepare()
    {
        $fileExists = file_exists($this->outputFilePathname);
        if($fileExists and !$this->replaceFile){
            throw new \Exception('File '.realpath($this->outputFilePathname).' already exists');
        }

        if($fileExists){
            unlink($this->outputFilePathname);
        }

        $this->handle = fopen($this->outputFilePathname,'w');


    }

    public function writeItem(array $item)
    {
        if($this->index == 0 and $this->writeHeader){
            fputcsv($this->handle,array_keys($item),$this->delimiter,$this->enclosure);
        }
        fputcsv($this->handle,array_values($item),$this->delimiter,$this->enclosure);
        $this->index++;
    }

    public function finish()
    {
        fclose($this->handle);
    }
}