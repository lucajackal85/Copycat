<?php


namespace Jackal\Copycat\Tests\Converter\ValueConverter;


use Jackal\Copycat\Converter\ValueConverter\ArrayToJSONConverter;
use PHPUnit\Framework\TestCase;

class ArrayToJSONConverterTest extends TestCase
{
    public function testArrayToJSON(){

        $converter = new ArrayToJSONConverter();

        $this->assertEquals('{"colA":"valueA"}',$converter(['colA' => 'valueA']));
    }
}