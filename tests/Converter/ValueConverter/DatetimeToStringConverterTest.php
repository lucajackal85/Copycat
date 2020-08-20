<?php

namespace Jackal\Importer\Tests\Converter\ValueConverter;

use Jackal\Copycat\Converter\ValueConverter\DatetimeToStringConverter;
use PHPUnit\Framework\TestCase;
use RuntimeException;

class DatetimeToStringConverterTest extends TestCase
{
    public function testItShouldConvertDateTime()
    {
        $dt = new \DateTime('2018-01-02 13:23:11');
        $converter = new DatetimeToStringConverter('b', 'H:i:s d/m/Y');

        $this->assertEquals(['b' => '13:23:11 02/01/2018'], $converter(['b' => $dt]));
    }

    public function testItShouldRaiseExceptionOnInvalidData()
    {
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Input must be DateTime object.');

        $dt = ['c' => 'invalid value'];
        $converter = new DatetimeToStringConverter('c');
        $converter($dt);
    }

    public function testItShouldReturnNullOnNullData(){

        $converter = new DatetimeToStringConverter('d','Y-m-d',true);

        $this->assertEquals(['d' => null], $converter(['d' => null]));
    }

    public function testItShouldRaiseExceptionOnEmptyData(){

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Input must be DateTime object.');

        $converter = new DatetimeToStringConverter('d','Y-m-d',true);

        $converter(['d' => '']);
    }

    public function testItShouldRaiseExceptionOnNullData(){

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('Input must be DateTime object.');

        $converter = new DatetimeToStringConverter('d');
        $converter(['d' => null]);
    }
}
