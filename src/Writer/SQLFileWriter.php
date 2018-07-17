<?php


namespace Jackal\Copycat\Writer;


class SQLFileWriter implements WriterInterface
{
    protected $outputFilePathname;
    protected $tablename;
    protected $replaceFile;
    protected $index;

    public function __construct($tablename,$outputFilePathname,$replaceFile = false)
    {
        $this->tablename = $tablename;
        $this->outputFilePathname = $outputFilePathname;
        $this->replaceFile = $replaceFile;
    }

    private function appendRow($content){
        file_put_contents($this->outputFilePathname, $content, FILE_APPEND);
    }


    public function writeItem(array $item)
    {
        if($this->index == 0) {
            $headString = sprintf("insert into %s (%s) values\n", $this->tablename, implode(', ',array_keys($item)));
            $this->appendRow($headString);
        }else{
            $this->appendRow(",\n");
        }


        $item = array_reduce($item,function ($outCell,$currentCell){
            //escape sql string
            $search = array("\\",  "\x00", "\n",  "\r",  "'",  '"', "\x1a");
            $replace = array("\\\\","\\0","\\n", "\\r", "\'", '\"', "\\Z");
            $outCell[] = '"'.str_replace($search, $replace, $currentCell).'"';
            return $outCell;
        },[]);

        $rowString = sprintf('(%s)',implode(', ',array_values($item)));
        $this->appendRow($rowString);
        $this->index++;
    }

    public function prepare()
    {
        if(!is_dir(dirname($this->outputFilePathname))){
            mkdir(dirname($this->outputFilePathname),0775,true);
        }

        $fileExists = file_exists($this->outputFilePathname);
        if($fileExists and !$this->replaceFile){
            throw new \Exception('File '.realpath($this->outputFilePathname).' already exists');
        }

        if($fileExists){
            unlink($this->outputFilePathname);
        }
    }

    public function finish()
    {
        $this->appendRow(';');
    }
}