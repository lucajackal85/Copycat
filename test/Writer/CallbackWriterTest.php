<?php


namespace Jackal\Copycat\Tests\Writer;


use Jackal\Copycat\Writer\CallbackWriter;
use PHPUnit\Framework\TestCase;

class CallbackWriterTest extends TestCase
{
    public function testCallCallback(){

        $outValues = [];

        $callbackWriter = new CallbackWriter(function($values) use (&$outValues){
            $outValues[] = $values;
        });

        $callbackWriter->writeItem(['key1' => 'this is a value']);
        $callbackWriter->writeItem(['key2' => 'this is a value 2']);

        $this->assertEquals([
            ['key1' => 'this is a value'],
            ['key2' => 'this is a value 2']
        ],$outValues);
    }
}