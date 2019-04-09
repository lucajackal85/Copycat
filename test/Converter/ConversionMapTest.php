<?php

namespace Jackal\Copycat\Tests\Converter;

use Jackal\Copycat\Converter\ConversionMap;
use PHPUnit\Framework\TestCase;

class ConversionMapTest extends TestCase
{
    public function testNotRaiseExceptionOnFieldValueNull()
    {
        $map = new ConversionMap();
        $map->add(function ($value) {
            $this->assertEquals([null],$value);
        });

        $val = [null];
        $map->apply($val);
    }
}
