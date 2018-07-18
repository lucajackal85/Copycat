<?php


namespace Jackal\Copycat\Tests\Writer;

use PHPUnit\Framework\TestCase;

abstract class AbstractFileTestCase extends TestCase
{
    protected $tmpFile;

    protected function setUp()
    {
        $this->tmpFile = __DIR__.'/tmp.txt';
    }

    public function assertFileContent($content)
    {
        $this->assertEquals($content, file_get_contents($this->tmpFile));
    }

    protected function tearDown()
    {
        if (is_file($this->tmpFile)) {
            unlink($this->tmpFile);
        }
    }
}
