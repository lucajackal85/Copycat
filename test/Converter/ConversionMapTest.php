<?php

namespace Jackal\Copycat\Tests\Converter;

use Jackal\Copycat\Converter\ConversionMap;
use PHPUnit\Framework\TestCase;

class ConversionMapTest extends TestCase
{
    public function testRaiseExceptionOnFieldNotFound()
    {
        $this->expectException(\RuntimeException::class);

        $map = new ConversionMap();
        $map->add('pippo', function ($values) {
            //do nothing
        });

        $val = ['pluto' => 'xxx'];
        $map->apply($val);
    }

    public function testNotRaiseExceptionOnFieldValueNull()
    {
        $map = new ConversionMap();
        $map->add('pippo', function ($value) {
            $this->assertNull($value);
        });

        $val = ['pippo' => null];
        $map->apply($val);
    }
}
