<?php


namespace Jackal\Copycat\Tests\Reader;

use Jackal\Copycat\Reader\JSONReader;

class JSONReaderTest
{
    public function testIteration()
    {
        $json = json_encode([
            ['cell11','cell21','cell31','cell41'],
            ['cell12','cell22','cell32','cell42'],
            ['cell13','cell23','cell33','cell43'],
        ]);

        $reader = new JSONReader($json);

        $this->assertEquals(['cell11','cell21','cell31','cell41'], $reader->get(0));
        $this->assertEquals(['cell12','cell22','cell32','cell42'], $reader->get(1));
        $this->assertEquals(['cell13','cell23','cell33','cell43'], $reader->get(2));
        $this->assertEquals(null, $reader->get(3));
        $this->assertEquals(3, $reader->count());
    }
}
