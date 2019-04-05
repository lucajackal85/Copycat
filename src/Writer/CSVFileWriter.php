<?php


namespace Jackal\Copycat\Writer;

use Symfony\Component\OptionsResolver\OptionsResolver;

class CSVFileWriter implements WriterInterface
{
    protected $outputFilePathname;
    protected $handle;
    protected $index = 0;

    protected $options = [];

    public function __construct($outputFilePathname, array $options = [])
    {
        $resolver = new OptionsResolver();
        $resolver->setDefaults([
            'replace_file' => false,
            'delimiter' => ',',
            'enclosure' => '"',
            'header' => true
        ]);

        $this->options = $resolver->resolve($options);

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
        if ($fileExists and !$this->options['replace_file']) {
            throw new \Exception('File '.realpath($this->outputFilePathname).' already exists');
        }

        if ($fileExists) {
            unlink($this->outputFilePathname);
        }

        $this->handle = fopen($this->outputFilePathname, 'w');
    }

    public function writeItem(array $item)
    {
        if ($this->index == 0 and $this->options['header']) {
            fputcsv($this->handle, array_keys($item), $this->options['delimiter'], $this->options['enclosure']);
        }
        fputcsv($this->handle, array_values($item), $this->options['delimiter'], $this->options['enclosure']);
        $this->index++;
    }

    public function finish()
    {
        fclose($this->handle);
    }
}
