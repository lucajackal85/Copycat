<?php


namespace Jackal\Copycat\Tests\Writer;

use Jackal\Copycat\Writer\SQLFileWriter;

class SQLFileWriterTest extends AbstractFileTestCase
{
    public function testWriteSQLFileWithNoDeleteFile()
    {
        $writer = new SQLFileWriter('pippo', $this->tmpFile, false);
        $writer->writeItem(['col1' => '1','col2' => '2']);
        $writer->writeItem(['col1' => '3','col2' => '4']);

        $this->assertFileContent("insert into pippo (col1, col2) values
(\"1\", \"2\"),
(\"3\", \"4\")");
    }
}
