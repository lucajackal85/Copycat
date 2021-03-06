<?php

namespace Jackal\Copycat\Reader;

use SplFileObject;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class CSVFileReader
 * @package Jackal\Copycat\Reader
 */
class CSVFileReader extends BaseReader
{
    /**
     * @var SplFileObject
     */
    protected $fileObject;

    /**
     * @var array
     */
    protected $options;

    /**
     * CSVFileReader constructor.
     * @param SplFileObject $fileObject
     * @param array $options
     */
    public function __construct(SplFileObject $fileObject, array $options = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'delimiter' => ',',
            'enclosure' => '"',
            'header' => true,
        ]);

        $this->options = $resolver->resolve($options);

        $this->fileObject = $fileObject;

        $headers = [];
        if ($this->options['header']) {
            $headers = $this->readCurrentRow();
        }

        while (($data = $this->readCurrentRow()) != false) {
            //skip empty rows
            if($data == [null]){
                continue;
            }
            if ($headers) {
                $this->addItem(array_combine($headers, $data));
            } else {
                $this->addItem($data);
            }
        }
    }

    protected function readCurrentRow()
    {
        return $this->fileObject->fgetcsv($this->options['delimiter'], $this->options['enclosure']);
    }
}
