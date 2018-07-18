<?php


namespace Jackal\Importer\Tests\Reader;

use Jackal\Copycat\Reader\ArrayReader;
use PHPUnit\Framework\TestCase;

class ArrayReaderTest extends TestCase
{
    public function testIteration()
    {
        $reader = new ArrayReader([
            ['cell11','cell21','cell31','cell41'],
            ['cell12','cell22','cell32','cell42'],
            ['cell13','cell23','cell33','cell43'],
        ]);

        $this->assertEquals(['cell11','cell21','cell31','cell41'], $reader->get(0));
        $this->assertEquals(['cell12','cell22','cell32','cell42'], $reader->get(1));
        $this->assertEquals(['cell13','cell23','cell33','cell43'], $reader->get(2));
        $this->assertEquals(null, $reader->get(3));
        $this->assertEquals(3, $reader->count());
    }
}
