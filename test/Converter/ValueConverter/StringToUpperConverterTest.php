<?php


namespace Jackal\Copycat\Tests\Converter\ValueConverter;


use Jackal\Copycat\Converter\ValueConverter\StringToUpperConverter;
use PHPUnit\Framework\TestCase;

class StringToUpperConverterTest extends TestCase
{
    public function testStringToUpperConverter(){

        $converter = new StringToUpperConverter();
        $this->assertEquals('AEIOU',$converter('aeiou'));

        $this->assertEquals('ÀÈÌÒÙ',$converter('àèìòù'));
    }
}