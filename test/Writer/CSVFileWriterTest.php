<?php


namespace Jackal\Importer\Tests\Writer;


use Jackal\Importer\Writer\CSVFileWriter;
use PHPUnit\Framework\TestCase;

class CSVFileWriterTest extends TestCase
{
    protected $tmpFile;
    protected function setUp()
    {
        $this->tmpFile = __DIR__.'/tmp.csv';
    }

    public function testWriteCSV(){

        $toWrite = [
            ['a' => '1','b' => '2'],
            ['a' => '3','b' => '4'],
        ];

        $delimiter = ';';
        $enclosure = '"';

        $writer = new CSVFileWriter($this->tmpFile,false,$delimiter,$enclosure);
        $writer->prepare();
        $writer->writeItem($toWrite[0],1,2);
        $writer->writeItem($toWrite[1],2,2);
        $writer->finish();
        $fileHandler = fopen($this->tmpFile,'r');

        $this->assertEquals(fgetcsv($fileHandler,0,$delimiter,$enclosure),array_keys($toWrite[0]));
        foreach ($toWrite as $value) {
            $this->assertEquals(fgetcsv($fileHandler,0,$delimiter,$enclosure), array_values($value));
        }
        $this->assertFalse(fgetcsv($fileHandler));
    }

    public function testWriteCSVNoHeader(){

        $toWrite = [
            ['a' => '1','b' => '2'],
            ['a' => '3','b' => '4'],
        ];

        $delimiter = ';';
        $enclosure = '"';

        $writer = new CSVFileWriter($this->tmpFile,false,$delimiter,$enclosure,false);
        $writer->prepare();
        $writer->writeItem($toWrite[0],1,2);
        $writer->writeItem($toWrite[1],2,2);
        $writer->finish();
        $fileHandler = fopen($this->tmpFile,'r');

        foreach ($toWrite as $value) {
            $this->assertEquals(fgetcsv($fileHandler,0,$delimiter,$enclosure), array_values($value));
        }
        $this->assertFalse(fgetcsv($fileHandler));
    }

    protected function tearDown()
    {
        if(is_file($this->tmpFile)){
            unlink($this->tmpFile);
        }
    }
}