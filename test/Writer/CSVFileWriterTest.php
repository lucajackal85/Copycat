<?php


namespace Jackal\Importer\Tests\Writer;

use Jackal\Copycat\Tests\Writer\AbstractFileTestCase;
use Jackal\Copycat\Writer\CSVFileWriter;

class CSVFileWriterTest extends AbstractFileTestCase
{
    public function testWriteCSV()
    {
        $toWrite = [
            ['a' => '1','b' => '2'],
            ['a' => '3','b' => '4'],
        ];

        $delimiter = ';';
        $enclosure = '"';

        $writer = new CSVFileWriter($this->tmpFile, [
            CSVFileWriter::OPT_DELIMITER => $delimiter,
            CSVFileWriter::OPT_ENCLOSURE => $enclosure
        ]);
        $writer->prepare();
        $writer->writeItem($toWrite[0], 1, 2);
        $writer->writeItem($toWrite[1], 2, 2);
        $writer->finish();
        $fileHandler = fopen($this->tmpFile, 'r');

        $this->assertEquals(fgetcsv($fileHandler, 0, $delimiter, $enclosure), array_keys($toWrite[0]));
        foreach ($toWrite as $value) {
            $this->assertEquals(fgetcsv($fileHandler, 0, $delimiter, $enclosure), array_values($value));
        }
        $this->assertFalse(fgetcsv($fileHandler));
    }

    public function testWriteCSVNoHeader()
    {
        $toWrite = [
            ['a' => '1','b' => '2'],
            ['a' => '3','b' => '4'],
        ];

        $delimiter = ';';
        $enclosure = '"';

        $writer = new CSVFileWriter($this->tmpFile, [
            CSVFileWriter::OPT_DELIMITER => $delimiter,
            CSVFileWriter::OPT_ENCLOSURE => $enclosure,
            CSVFileWriter::OPT_HEADER => false
        ]);
        $writer->prepare();
        $writer->writeItem($toWrite[0], 1, 2);
        $writer->writeItem($toWrite[1], 2, 2);
        $writer->finish();
        $fileHandler = fopen($this->tmpFile, 'r');

        foreach ($toWrite as $value) {
            $this->assertEquals(fgetcsv($fileHandler, 0, $delimiter, $enclosure), array_values($value));
        }
        $this->assertFalse(fgetcsv($fileHandler));
    }
}
