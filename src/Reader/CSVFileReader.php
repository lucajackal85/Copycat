<?php


namespace Jackal\Copycat\Reader;


use Symfony\Component\OptionsResolver\OptionsResolver;

class CSVFileReader extends ArrayReader
{
    protected $fileObject;
    protected $options;

    public function __construct(\SplFileObject $fileObject,array $options = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'delimiter' => ',',
            'enclosure' => '"',
            'header' => true
        ]);

        $this->options = $resolver->resolve($options);

        $this->fileObject = $fileObject;

        $headers = [];
        if($this->options['header']){
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
        $data = $this->fileObject->fgetcsv($this->options['delimiter'],$this->options['enclosure']);
        //remove last empy line if exists
        if($data == [null]){
            return false;
        }
        return $data;
    }
}