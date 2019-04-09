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

        $dt = ['c' => 'invalid value'];
        $converter = new DatetimeToStringConverter('c');
        $converter($dt);
    }
}
