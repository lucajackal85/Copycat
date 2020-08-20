<?php


namespace Jackal\Copycat\Tests\Converter\ValueConverter;

use Jackal\Copycat\Converter\ValueConverter\StringToObjectConverter;
use PHPUnit\Framework\TestCase;

class StringToObjectConverterTest extends TestCase
{
    public function testItShouldConvertStringToObject(){
        $testObject = new \DateTime();

        $converter = new StringToObjectConverter('col');

        $this->assertEquals(['col' => $testObject],$converter(['col' => serialize($testObject)]));
    }

    public function testItShouldRaiseExceptionOnParsingError(){

        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Error converting string to object.');

        $converter = new StringToObjectConverter('col');
        $converter(['col' => 'malformed serialized object']);
    }

    public function testItShouldNotRaiseExceptionOnFalseValue(){

        $converter = new StringToObjectConverter('col');

        $this->assertEquals(['col' => false],$converter(['col' => serialize(false)]));
    }
}