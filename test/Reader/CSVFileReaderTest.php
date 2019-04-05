<?php


namespace Jackal\Copycat\Tests\Reader;


use Jackal\Copycat\Reader\CSVFileReader;
use PHPUnit\Framework\TestCase;

class CSVFileReaderTest extends TestCase
{
    public function testIteration(){

        $reader = new CSVFileReader(new \SplFileObject(__DIR__.'/CSVFileReaderTest.csv'));

        $this->assertEquals(['a' => 'cell11','b' => 'cell21','c' => 'cell31','d' => 'cell41'], $reader->get(0));
        $this->assertEquals(['a' => 'cell12','b' => 'cell22','c' => 'cell32','d' => 'cell42'], $reader->get(1));
        $this->assertEquals(['a' => 'cell13','b' => 'cell23','c' => 'cell33','d' => 'cell43'], $reader->get(2));
        $this->assertEquals(null, $reader->get(3));
        $this->assertEquals(3, $reader->count());
    }

    public function testIteration_NoHeader(){

        $reader = new CSVFileReader(new \SplFileObject(__DIR__.'/CSVFileReaderTest.csv'),[
            CSVFileReader::OPT_HEADER => false
        ]);

        $this->assertEquals(['a','b','c','d'],$reader->get(0));
        $this->assertEquals(['cell11','cell21','cell31','cell41'], $reader->get(1));
        $this->assertEquals(['cell12','cell22','cell32','cell42'], $reader->get(2));
        $this->assertEquals(['cell13','cell23','cell33','cell43'], $reader->get(3));
        $this->assertEquals(null, $reader->get(4));
        $this->assertEquals(4, $reader->count());
    }
}