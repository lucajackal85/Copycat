<?php


namespace Jackal\Importer\Tests\Converter;


use Jackal\Copycat\Converter\ValueConverter\DatetimeToStringConverter;
use PHPUnit\Framework\TestCase;

class DatetimeToStringConverterTest extends TestCase
{
    public function testItShouldConvertDateTime(){

        $dt = new \DateTime('2018-01-02 13:23:11');
        $converter = new DatetimeToStringConverter('H:i:s d/m/Y');

        $this->assertEquals('13:23:11 02/01/2018',$converter($dt));
    }

    public function testItShouldRaiseExceptionOnInvalidData(){
        $this->expectException(\Exception::class);

        $dt = 'invalid value';
        $converter = new DatetimeToStringConverter();
        $converter($dt);
    }
}