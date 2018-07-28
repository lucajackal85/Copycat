<?php


namespace Jackal\Copycat\Tests\Writer;

use Jackal\Copycat\Writer\ArrayWriter;
use PHPUnit\Framework\TestCase;

class ArrayWriterTest extends TestCase
{
    public function testWriteToArray()
    {
        $emptyArr = [];

        $writer = new ArrayWriter($emptyArr);
        $writer->writeItem(['value1']);
        $writer->writeItem(['value2']);

        $this->assertEquals([
            ['value1'],
            ['value2']
        ], $emptyArr);
    }
}
