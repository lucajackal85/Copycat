<?php


namespace Jackal\Copycat\Tests\Writer;

use Jackal\Copycat\Writer\ArrayWriter;
use PHPUnit\Framework\TestCase;

class ArrayWriterTest extends TestCase
{
    public function testWriteToArray()
    {
        $writer = new ArrayWriter($emptyArr);

        $this->assertEquals([], $emptyArr);
    }
}
