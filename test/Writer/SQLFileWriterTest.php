<?php


namespace Jackal\Copycat\Tests\Writer;

use Jackal\Copycat\Writer\SQLFileWriter;

class SQLFileWriterTest extends AbstractFileTestCase
{
    public function testWriteSQLFileWithNoDeleteFile()
    {
        $writer = new SQLFileWriter('pippo', $this->tmpFile);
        $writer->writeItem(['col1' => '1','col2' => '2']);
        $writer->writeItem(['col1' => '3','col2' => '4']);

        $this->assertFileContent("insert into pippo (col1, col2) values
(\"1\", \"2\"),
(\"3\", \"4\")");
    }

    public function testWriteSQLFile_FillWithNulls()
    {
        $writer = new SQLFileWriter('pippo', $this->tmpFile);
        $writer->writeItem(['col1' => '1','col2' => '2']);
        $writer->writeItem(['col1' => '3','col2' => null]);

        $this->assertFileContent("insert into pippo (col1, col2) values
(\"1\", \"2\"),
(\"3\", null)");
    }

    public function testWriteSQLFile_FillWithSkippedColumn()
    {
        $writer = new SQLFileWriter('pippo', $this->tmpFile);
        $writer->writeItem(['col1' => '1','col2' => '2']);
        $writer->writeItem(['col1' => '3','col2' => null,'col3' => 'this will not be added']);

        $this->assertFileContent("insert into pippo (col1, col2) values
(\"1\", \"2\"),
(\"3\", null)");
    }

    public function testWriteSQLFile_NoColumnsName()
    {
        $writer = new SQLFileWriter('pippo', $this->tmpFile);
        $writer->writeItem(['1','2']);
        $writer->writeItem(['3','4']);

        $this->assertFileContent("insert into pippo (0, 1) values
(\"1\", \"2\"),
(\"3\", \"4\")");
    }

    public function testWriteSQLFile_DefinedColumns()
    {
        $writer = new SQLFileWriter('pippo', $this->tmpFile, [
            'columns' => ['col1','col2','col3','col4','col5','col6'],
            'exception_on_extra_columns' => false
        ]);
        $writer->writeItem(['col1' => '1','col2' => '2']);
        $writer->writeItem(['col3' => '3','col4' => '4']);
        $writer->writeItem(['col5' => '5','col6' => '6']);
        $writer->writeItem(['col7' => 'this will not be added','col6' => '6']);

        $this->assertFileContent("insert into pippo (col1, col2, col3, col4, col5, col6) values
(\"1\", \"2\", null, null, null, null),
(null, null, \"3\", \"4\", null, null),
(null, null, null, null, \"5\", \"6\"),
(null, null, null, null, null, \"6\")");
    }

    public function testRaiseExceptionOnExtraColumns()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Row 2 had extra columns "col3". (Defined columns: "col1", "col2")');

        $writer = new SQLFileWriter('pippo', $this->tmpFile, [
            'columns' => ['col1','col2'],
            'exception_on_extra_columns' => true
        ]);
        $writer->writeItem(['col1' => '1','col2' => '2']);
        $writer->writeItem(['col2' => '2','col3' => 'this will raise exception']);
    }

    public function testWriteSQLWithDeleteData()
    {
        $writer = new SQLFileWriter('pippo', $this->tmpFile, [
            'drop_data' => true
        ]);
        $writer->writeItem(['col1' => '1','col2' => '2']);
        $writer->writeItem(['col1' => '3','col2' => '4']);

        $this->assertFileContent("delete from pippo
insert into pippo (col1, col2) values
(\"1\", \"2\"),
(\"3\", \"4\")");
    }
}
