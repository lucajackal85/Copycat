<?php


namespace Jackal\Copycat\Reader;


class CSVFileReader extends ArrayReader
{
    const OPT_DELIMITER = 'delimiter';
    const OPT_ENCLOSURE = 'enclosure';
    const OPT_HEADER = 'header';

    protected $fileObject;
    protected $options;

    public function __construct(\SplFileObject $fileObject,array $options = [])
    {
        $this->options = array_merge([
            self::OPT_DELIMITER => ',',
            self::OPT_ENCLOSURE => '"',
            self::OPT_HEADER => true
        ],$options);

        $this->fileObject = $fileObject;

        $headers = [];
        if($this->options[self::OPT_HEADER]){
            $headers = $this->readCurrentRow();
        }

        while (($data = $this->readCurrentRow()) != false) {
            if($headers) {
                $this->items[] = array_combine($headers, $data);
            }else{
                $this->items[] = $data;
            }
        }
    }

    protected function readCurrentRow(){
        $data = $this->fileObject->fgetcsv($this->options[self::OPT_DELIMITER],$this->options[self::OPT_ENCLOSURE]);
        //remove last empy line if exists
        if($data == [null]){
            return false;
        }
        return $data;
    }
}