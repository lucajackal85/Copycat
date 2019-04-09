<?php


namespace Jackal\Copycat\Tests\Writer;

use Jackal\Copycat\Writer\ArrayWriter;
use Jackal\Copycat\Writer\JSONWriter;
use PHPUnit\Framework\TestCase;

class JSONWriterTest extends TestCase
{
    public function testWriteToArray()
    {
        $writer = new JSONWriter($emptyJson);
        $writer->writeItem(['value1']);
        $writer->writeItem(['value2']);
        $writer->finish();

        $this->assertEquals(json_encode([
            ['value1'],
            ['value2']
        ]), $emptyJson);
    }
}
