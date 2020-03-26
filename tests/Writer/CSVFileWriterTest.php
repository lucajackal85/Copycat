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
            'delimiter' => $delimiter,
            'enclosure' => $enclosure,
        ]);
        $writer->prepare();
        foreach ($toWrite as $toWriteRow) {
            $writer->writeItem($toWriteRow);
        }
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
            'delimiter' => $delimiter,
            'enclosure' => $enclosure,
            'header' => false,
        ]);
        $writer->prepare();
        foreach ($toWrite as $toWriteRow) {
            $writer->writeItem($toWriteRow);
        }
        $writer->finish();
        $fileHandler = fopen($this->tmpFile, 'r');

        $this->assertEquals(fgetcsv($fileHandler, 0, $delimiter, $enclosure), ['1','2']);
        $this->assertEquals(fgetcsv($fileHandler, 0, $delimiter, $enclosure), ['3','4']);
        $this->assertFalse(fgetcsv($fileHandler));
    }

    public function testWriteCSVOrderedColumns()
    {
        $toWrite = [
            ['a' => '1','b' => '2','c' => '3'],
            ['a' => '4','c' => '6','b' => '5'],
            ['a' => '7','c' => '9'],
            ['a' => '10','d' => 'not been showed'],
        ];

        $delimiter = ';';
        $enclosure = '"';

        $writer = new CSVFileWriter($this->tmpFile, [
            'delimiter' => $delimiter,
            'enclosure' => $enclosure,
            'columns' => ['a','b','c'],
        ]);

        $writer->prepare();
        foreach ($toWrite as $toWriteRow) {
            $writer->writeItem($toWriteRow);
        }
        $writer->finish();
        $fileHandler = fopen($this->tmpFile, 'r');

        $this->assertEquals(fgetcsv($fileHandler, 0, $delimiter, $enclosure), ['a','b','c']);
        $this->assertEquals(fgetcsv($fileHandler, 0, $delimiter, $enclosure), ['1','2','3']);
        $this->assertEquals(fgetcsv($fileHandler, 0, $delimiter, $enclosure), ['4','5','6']);
        $this->assertEquals(fgetcsv($fileHandler, 0, $delimiter, $enclosure), ['7','','9']);
        $this->assertEquals(fgetcsv($fileHandler, 0, $delimiter, $enclosure), ['10','','']);
        $this->assertFalse(fgetcsv($fileHandler));
    }
}
